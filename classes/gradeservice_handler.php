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
 * Handles interaction with gradeservice api.
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
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

/**
 * Handles interaction with gradeservice api.
 *
 * @package mod_jupyter
 */
class gradeservice_handler {

    /** @var Client guzzle http client */
    private $client;

    /**
     * Constructor
     */
    public function __construct() {
        $this->client = new Client([
            'base_uri' => get_config('mod_jupyter', 'gradeservice_url'),
            // TODO: auth.
        ]);
    }

    /**
     * Create an assignment.
     *
     * @param int $courseid
     * @param int $contextid
     * @return void
     * @throws coding_exception
     * @throws GuzzleException
     */
    public function create_assignment(int $courseid, int $contextid) : void {
        $fs = get_file_storage();
        $files = $fs->get_area_files($contextid, 'mod_jupyter', 'package', 0, 'id', false);
        $file = reset($files);

        $route = "/{$courseid}/{$contextid}";

        $this->client->request("POST", $route, [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => $file->get_content(),
                ]
            ]
        ]);
    }
}
