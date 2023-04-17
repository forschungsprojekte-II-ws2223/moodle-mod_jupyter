<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Handles interaction with jupyter api.
 *
 * Reference for the used jupyterhub and jupyterlab api's:
 * https://jupyterhub.readthedocs.io/en/stable/reference/rest-api.html
 * https://jupyter-server.readthedocs.io/en/latest/developers/rest-api.html
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_jupyter;

defined('MOODLE_INTERNAL') || die();
require($CFG->dirroot . '/mod/jupyter/vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

/**
 * Handles interaction with jupyter api.
 *
 * @package mod_jupyter
 */
class jupyterhub_handler {

    /** @var Client guzzle http client */
    private $client;

    /** @var string username */
    private string $user;

    /** @var int contextid needed to get file for activity */
    private int $contextid;

    /**
     * Constructor.
     *
     * @param string $user
     * @param int $contextid
     */
    public function __construct(string $user, int $contextid) {
        $this->client = new Client([
        'base_uri' => get_config('mod_jupyter', 'jupyterhub_url'), // TODO: Check if moodle is actually running in docker!
        'headers' => [
          'Authorization' => 'token ' . get_config('mod_jupyter', 'jupyterhub_api_token')
        ]
          ]);

        $this->user = $user;
        $this->contextid = $contextid;
    }

    /**
     * Sets the private $client variable.
     *
     * @param Client $client guzzle http client
     */
    public function set_client($client) {
        $this->client = $client;
    }

    /**
     * Returns the url to users notebook and notebook file.
     *
     * @return string
     * @throws ConnectException
     * @throws RequestException
     */
    public function get_notebook_path() : string {
        $this->check_jupyterhub_reachable();
        $this->check_user_status();

        return $this->check_notebook_status();
    }

    /**
     * Check if jupyterhub is reachable
     *
     */
    private function check_jupyterhub_reachable() {
        try {
            $res = $this->client->get("/");
        } catch (RequestException $e) {
            if (!($e->hasResponse() && $e->getCode() == 401)) {
                throw $e;
            }
        } catch (ConnectException $e) {
            $this->client = new Client([
                'base_uri' => str_replace(
                    '127.0.0.1',
                    'host.docker.internal',
                    get_config('mod_jupyter', 'jupyterhub_url')), // TODO: Check if moodle is actually running in docker!
                'headers' => [
                  'Authorization' => 'token ' . get_config('mod_jupyter', 'jupyterhub_api_token')
                ]
                  ]);
        }
    }

    /**
     * Check if user exists and spawn server
     *
     * @return void
     * @throws ConnectException
     * @throws RequestException
     */
    private function check_user_status() {
        $route = "/hub/api/users/{$this->user}";
        // Check if user exists.
        try {
            $res = $this->client->get($route);
        } catch (RequestException $e) {
            // Create user if not found.
            if ($e->hasResponse() && $e->getCode() == 404) {
                $res = $this->client->post($route);
            } else {
                // For other errors we throw the exception.
                throw $e;
            }
        }

        // Spawn users server if not running.
        if (json_decode($res->getBody(), true)["server"] == null) {
            $res = $this->client->post($route . "/server");
            /** //phpcs:ignore moodle.Commenting.InlineComment.DocBlock
             * Should return 201 created.
             * Could also return 202 accepted which means server is started asynchronous.
             * We would have to wait for the server to be ready then using progress api.
             * Example: http://jupyterhub.readthedocs.io/en/stable/reference/server-api.html
             * TODO: handle 202.
             */
        }
    }

    /**
     * Check if notebook exists on users server already. If not upload it to the users server.
     *
     * @return string returns a link to the notebook file
     * @throws RequestException
     * @throws ConnectException
     */
    private function check_notebook_status() : string {
        $fs = get_file_storage();
        $files = $fs->get_area_files($this->contextid, 'mod_jupyter', 'package', 0, 'id', false);
        $file = reset($files);
        $filename = $file->get_filename();

        $route = "/user/{$this->user}/api/contents/{$filename}";

        // Check if file is already there.
        try {
            $this->client->get($route, ['query' => ['content' => '0']]);
        } catch (RequestException $e) {
            if ($e->hasResponse() && $e->getCode() == 404) {
                $this->client->put($route, ['json' => [
                'type' => 'file',
                'format' => 'base64',
                'content' => base64_encode($file->get_content()),
                ]]);
            } else {
                throw $e;
            }
        }

        return "/hub/user-redirect/lab/tree/{$filename}";
    }
}
