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

use dml_exception;
use DomainException;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use mod_jupyter\jupyterhub_handler;
use stdClass;

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
        $baseuri = get_config('mod_jupyter', 'gradeservice_url');

        if (getenv('IS_CONTAINER') == 'yes') {
            $baseuri = str_replace(['127.0.0.1', 'localhost'], 'host.docker.internal', $baseuri);
        }

        $this->client = new Client([
        'base_uri' => $baseuri,
        ]);
    }

    /**
     * Create an assignment.
     *
     * @param stdClass $moduleinstance
     * @param int $contextid activity context id
     * @param string $token authorization token
     * @return string filename of the created assignment
     */
    public function create_assignment(stdClass $moduleinstance, int $contextid, string $token) : string {
        global $DB;

        $fs = get_file_storage();
        $files = $fs->get_area_files($contextid, 'mod_jupyter', 'package', 0, 'id', false);
        $file = reset($files);
        $filename = $file->get_filename();

        $route = "/{$moduleinstance->course}/{$moduleinstance->id}";

        $res = $this->client->request("POST", $route, [
            'headers' => [
                'Authorization' => $token,
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => $file->get_content(),
                    'filename' => $filename,
                ]
            ]
        ]);
        $res = json_decode($res->getBody(), true);

        $file = base64_decode($res[$filename]);
        $fs->delete_area_files($contextid, 'mod_jupyter', 'assignment');
        $fileinfo = array(
            'contextid' => $contextid,
            'component' => 'mod_jupyter',
            'filearea' => 'assignment',
            'itemid' => 0,
            'filepath' => '/',
            'filename' => $filename
        );
        $fs->create_file_from_string($fileinfo, $file);
        $moduleinstance->assignment = $filename;

        $questions = array();
        foreach ($res['points'] as $questionnr => $maxpoints) {
            $question = new stdClass();
            $question->jupyter = $moduleinstance->id;
            $question->questionnr = $questionnr;
            $question->maxpoints = $maxpoints;
            $questions[] = $question;
        }

        $DB->insert_records('jupyter_questions', $questions);
        $moduleinstance->grade = $res['total'];

        $DB->update_record('jupyter', $moduleinstance);
        jupyter_grade_item_update($moduleinstance);

        return $filename;
    }

    /**
     * Delete assignment.
     * @param stdClass $moduleinstance
     * @return void
     * @throws dml_exception
     * @throws DomainException
     * @throws GuzzleException
     */
    public function delete_assignment(stdClass $moduleinstance) {
        global $USER;
        $jwt = JWT::encode(["name" => $USER->username], get_config('mod_jupyter', 'jupyterhub_jwt_secret'), 'HS256');

        $this->client->request("DELETE", "/{$moduleinstance->course}/{$moduleinstance->id}", [
            'headers' => [
                'Authorization' => $jwt
            ]
        ]);
    }

    /**
     * Submit an assignment.
     *
     * @param string $user user name of the student that submitted the file
     * @param int $courseid ID of the Moodle course
     * @param int $instanceid ID of the activity instance
     * @param string $filename name of the submitted notebook file
     * @param string $token Gradeservice authorization JWT
     */
    public function submit_assignment(string $user, int $courseid, int $instanceid, string $filename, string $token) : string {
        global $CFG, $DB, $USER;
        $userid = $USER->id;
        require_once($CFG->libdir.'/gradelib.php');

        $handler = new jupyterhub_handler();
        $file = $handler->get_notebook($user, $courseid, $instanceid, $filename);

        $route = "/{$courseid}/{$instanceid}/{$user}";
        $res = $this->client->request("POST", $route, [
            'headers' => [
                'Authorization' => $token,
            ],
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => $file,
                    'filename' => $filename,
                ]
            ]
        ]);
        $res = json_decode($res->getBody(), true);

        if ($grade = $DB->get_record('jupyter_grades', array('jupyter' => $instanceid, 'userid' => $userid))) {

            $grade->grade = $res['total'];
            $grade->timemodified = time();

            $DB->update_record('jupyter_grades', $grade);
        } else {
            $grade = new stdClass();
            $grade->jupyter = $instanceid;
            $grade->userid = $userid;
            $grade->grade = $res['total'];
            $grade->timemodified = time();

            $DB->insert_record('jupyter_grades', $grade);
        }
        $this->update_grade($courseid, $instanceid, $grade);

        if ($questions = $DB->get_records('jupyter_questions_points', array('jupyter' => $instanceid, 'userid' => $userid))) {
            foreach ($questions as $question) {
                $question->points = $res['points'][$question->questionnr];
                $question->output = $res['output'][$question->questionnr];
                $DB->update_record('jupyter_questions_points', $question);
            }
        } else {
            $questions = array();

            foreach ($res['points'] as $questionnr => $points) {
                $question = new stdClass();
                $question->jupyter = $instanceid;
                $question->userid = $userid;
                $question->questionnr = $questionnr;
                $question->points = $points;
                $question->output = $res['output'][$question->questionnr];
                $questions[] = $question;
            }

            $DB->insert_records('jupyter_questions_points', $questions);
        }

        return "assignment submitted";
    }

    /**
     * Update grade in gradebook.
     *
     * @param int $courseid activity course id
     * @param int $instanceid activity instance id
     * @param stdClass $grade the grade from jupyter_grades table
     */
    private function update_grade(int $courseid, int $instanceid, stdClass $grade) {
        global $CFG;
        require_once($CFG->libdir.'/gradelib.php');

        $grades = array();
        $gradeobject = new stdClass();
        $gradeobject->userid = $grade->userid;
        $gradeobject->rawgrade = $grade->grade;
        $gradeobject->dategraded = $grade->timemodified;
        $grades[$grade->userid] = $gradeobject;
        grade_update('/mod/jupyter', $courseid, 'mod', 'jupyter', $instanceid, 0, $grades);
    }
}
