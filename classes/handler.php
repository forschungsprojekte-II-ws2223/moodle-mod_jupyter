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
 * Provides function for creating an error message.
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

use coding_exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Exception\MalformedUriException;

/**
 * Handles interaction with jupyter api.
 *
 * @package mod_jupyter
 */
class handler {

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
        'base_uri' => 'http://host.docker.internal:8000',
        'headers' => [
          'Authorization' => 'token secret-token'
        ]
          ]);

        $this->user = $user;
        $this->contextid = $contextid;
    }

    /**
     * Returns the url to users notebook and notebook file.
     *
     * @return string
     * @throws GuzzleException
     */
    public function jupyter_url() : string {
        $this->check_user_status();

        return $this->check_notebook_status();
    }

    // TODO: error handling!
    /**
     * Check if user exists and spawn container
     *
     * @return void
     * @throws GuzzleException
     */
    private function check_user_status() {
        $client = $this->client;
        $route = "/hub/api/users/{$this->user}";
        // Check if user exists.
        try {
            $res = $client->get($route);
        } catch (RequestException $e) {
            // Create user if not found.
            if ($e->getCode() == 404) {
                $res = $client->post($route);
            }
        }

        // Spawn users server if not running.
        if (json_decode($res->getBody(), true)["server"] == null) {
            $client->post($route . "/servers/");
        }
    }


    // TODO: error handling!
    /**
     * Check if notebook exists
     *
     * @return string
     * @throws coding_exception
     * @throws GuzzleException
     */
    private function check_notebook_status() : string {
        $fs = get_file_storage();
        $files = $fs->get_area_files($this->contextid, 'mod_jupyter', 'package', 0, 'id', false);
        $file = reset($files);
        $filename = $file->get_filename();

        $route = "/user/{$this->user}/api/contents/work/{$filename}";

        // Check if file is already there.
        try {
            $this->client->get($route, ['query' => ['content' => '0']]);
        } catch (RequestException $e) {
            if ($e->getCode() == 404) {
                $res = $this->client->put($route, ['json' => [
                'type' => 'file',
                'format' => 'base64',
                'content' => base64_encode($file->get_content()),
                ]]);
            }
        }

        return "/hub/user-redirect/lab/tree/work/{$filename}";
    }
}
