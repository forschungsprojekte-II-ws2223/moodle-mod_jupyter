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

class handler {

    private $client;

    private string $user;

    private int $contextid;

    public function __construct(string $user, int $contextid) {
        $this->client = new Client([
            'base_uri' => 'http://127.0.0.1:8000',
            'headers' => [
              'Authorization' => 'token secret-token'
            ]
          ]);

        $this->user = $user;
        $this->contextid = $contextid;
    }

    public function jupyter_url() : string {
        $this->check_user_status();

        return "";
    }

    // TODO: error handling!
    /**
     *
     * @return void
     * @throws GuzzleException
     */
    private function check_user_status() {
        $client = $this->client;
        // Check if user exists.
        try {
            $res = $client->get("/hub/api/users/{$this->user}");
        } catch (RequestException $e) {
            // Create user if not found.
            if ($e->getCode() == 404) {
                $res = $client->post("/hub/api/users/{$this->user}");
            }
        }

        // Spawn users server if not running.
        if (json_decode($res->getBody(), true)["server"] == null) {
            $res = $client->post("/hub/api/users/{$this->user}/servers/");
        }
    }


    // TODO: error handling!
    /**
     *
     * @return void
     * @throws coding_exception
     * @throws GuzzleException
     */
    private function check_notebook_status() {
        $fs = get_file_storage();
        $files = $fs->get_area_files($this->contextid, 'mod_jupyter', 'package', 0, 'id', false);
        $file = reset($files);

        $route = "/user/{$this->user}/contents/{$file->get_filename()}";

        $res = $this->client->get($route);

        if ($res->getStatusCode() == 404) {
            $f = base64_encode($file->get_content());

            $res = $this->client->put($route)
        }
    }
}
