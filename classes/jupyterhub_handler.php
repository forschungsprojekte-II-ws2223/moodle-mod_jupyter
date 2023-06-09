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

    /**
     * Constructor.
     */
    public function __construct() {
        $baseuri = get_config('mod_jupyter', 'jupyterhub_url');

        // If moodle is running in a docker container we have to replace '127.0.0.1' and 'localhost' with 'host.docker.internal'.
        // This is only relevant for local testing.
        if (getenv('IS_CONTAINER') == 'yes') {
            $baseuri = str_replace(['127.0.0.1', 'localhost'], 'host.docker.internal', $baseuri);
        }

        if (substr($baseuri, -1) != "/") {
            $baseuri = $baseuri . "/";
        }

        $this->client = new Client([
        'base_uri' => $baseuri,
        'headers' => [
          'Authorization' => 'token ' . get_config('mod_jupyter', 'jupyterhub_api_token')
        ]
          ]);
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
     * @param string $user current user's username
     * @param int $contextid activity context id
     * @param int $courseid id of the moodle course
     * @param int $instanceid activity instance id
     * @param int $autograded
     * @return string path to file on jupyterhub server
     * @throws ConnectException
     * @throws RequestException
     */
    public function get_notebook_path(string $user, int $contextid, int $courseid, int $instanceid, int $autograded) : string {
        $this->check_user_status($user);

        $route = "user/{$user}/api/contents";

        $fs = get_file_storage();
        $filearea = $autograded ? 'assignment' : 'package';
        $files = $fs->get_area_files($contextid, 'mod_jupyter', $filearea, 0, 'id', false);
        $file = reset($files);
        $filename = $file->get_filename();

        try {
            // Check if file is already there.
            $this->client->get("{$route}/{$courseid}/{$instanceid}/{$filename}", ['query' => ['content' => '0']]);
        } catch (RequestException $e) {
            if ($e->hasResponse() && $e->getCode() == 404) {

                // Jupyter api doesnt support creating directorys recursively so we have to it like this.
                $this->client->put("{$route}/{$courseid}", ['json' => ['type' => 'directory']]);
                $this->client->put("{$route}/{$courseid}/{$instanceid}", ['json' => ['type' => 'directory']]);

                $this->client->put("{$route}/{$courseid}/{$instanceid}/{$filename}", ['json' => [
                    'type' => 'file',
                    'format' => 'base64',
                    'content' => base64_encode($file->get_content()),
                ]]);
            } else {
                throw $e;
            }
        }

        return "/hub/user-redirect/lab/tree/{$courseid}/{$instanceid}/{$filename}";
    }

    /**
     * Check if user exists and spawn server
     * @param string $user current user's username
     * @throws ConnectException
     * @throws RequestException
     */
    private function check_user_status(string $user) {
        $route = "hub/api/users/{$user}";
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
        }
    }

    /**
     * Reset notebook server by reuploading default notebookfile.
     * @param string $user current user's username
     * @param int $contextid activity context id
     * @param int $courseid id of the moodle course
     * @param int $instanceid activity instance id
     * @param int $autograded
     * @throws RequestException
     * @throws ConnectException
     */
    public function reset_notebook(string $user, int $contextid, int $courseid, int $instanceid, int $autograded) {
        $fs = get_file_storage();
        $filearea = $autograded ? 'assignment' : 'package';
        $files = $fs->get_area_files($contextid, 'mod_jupyter', $filearea, 0, 'id', false);
        $file = reset($files);
        $filename = $file->get_filename();

        $route = "user/{$user}/api/contents/{$courseid}/{$instanceid}/{$filename}";

        try {
                $this->client->patch($route, ['json' => [
                    'path' => "{$courseid}/{$instanceid}/" . date('Y-m-d-H:i:s', time()) . "_{$filename}"
                ]]);
                $this->client->put($route, ['json' => [
                    'type' => 'file',
                    'format' => 'base64',
                    'content' => base64_encode($file->get_content()),
                ]]);
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
    }

    /**
     * Return the notebook file associated to the given parameters.
     * @param string $user user name of the owner of the notebook
     * @param int $courseid activity course id
     * @param int $instanceid activity instance id
     * @param string $filename notebook file name
     * @return string returns the decoded notebook file contents
     * @throws RequestException
     * @throws ConnectException
     */
    public function get_notebook(string $user, int $courseid, int $instanceid, string $filename) {
        $route = "user/{$user}/api/contents/{$courseid}/{$instanceid}/{$filename}";

        $res = $this->client->get($route,
        ['query' => [
            'content' => '1',
            'format' => 'base64',
            'type' => 'file'
            ]
        ]);
        $res = json_decode($res->getBody(), true);
        return base64_decode($res['content']);
    }
}
