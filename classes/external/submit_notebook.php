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

namespace mod_jupyter\external;

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->dirroot/mod/jupyter/lib.php");


use mod_jupyter\gradeservice_handler;
use external_function_parameters;
use external_value;
use external_multiple_structure;
use external_single_structure;
use stdClass;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

/**
 * Jupyter web service class for submitting a notebook for autograding.
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class submit_notebook extends \external_api {
    /**
     * Returns description of method parameters.
     * @return external_function_parameters
     */
    public static function execute_parameters() {
        return new external_function_parameters([
            'user' => new external_value(PARAM_RAW, VALUE_REQUIRED, 'unique user id'),
            'courseid' => new external_value(PARAM_RAW, VALUE_REQUIRED, 'module course id'),
            'instanceid' => new external_value(PARAM_RAW, VALUE_REQUIRED, 'module instance id'),
            'filename' => new external_value(PARAM_RAW, VALUE_REQUIRED, 'notebook file name'),
            'token' => new external_value(PARAM_RAW, VALUE_REQUIRED, 'Gradeservice JWT')
        ]);
    }

    /**
     * Get notebookfile from notebook server and send it to autograding.
     *
     * @param string $user user name of the student that submitted the file
     * @param int $courseid ID of the Moodle course
     * @param int $instanceid ID of the activity instance
     * @param string $filename name of the submitted notebook file
     * @param string $token Gradeservice authorization JWT
     * @return array $points Response array of graded question results
     */
    public static function execute(string $user, int $courseid, int $instanceid, string $filename, string $token) : array {
        global $CFG, $DB, $USER;
        $handler = new gradeservice_handler();

        $points = array();

        try {
            $handler->submit_assignment($user, $courseid, $instanceid, $filename, $token);
            $questions = $DB->get_records('jupyter_questions_points', array('jupyter' => $instanceid, 'userid' => $USER->id), '');
        } catch (ConnectException $e) {
            $error = new stdClass;
            $cm = $DB->get_record('course_modules', array('course' => $courseid, 'instance' => $instanceid));
            $modulecontext = \context_module::instance($cm->id);

            if (has_capability('mod/jupyter:viewerrordetails', $modulecontext)) {
                $error->errormessage = get_string('gradeservice_connect_err_admin', 'jupyter', [
                'url' => get_config('mod_jupyter', 'gradeservice_url'),
                'msg' => "{$e->getCode()}: {$e->getMessage()}"
                ]);
            } else {
                $error->errormessage = get_string('gradeservice_connect_err', 'jupyter');
            }
        } catch (RequestException $e) {
            $error = new stdClass;
            $cm = $DB->get_record('course_modules', array('course' => $courseid, 'instance' => $instanceid));
            $modulecontext = \context_module::instance($cm->id);
            if (has_capability('mod/jupyter:viewerrordetails', $cmid)) {
                $error->errormessage = get_string('gradeservice_resp_err_admin', 'jupyter', [
                'url' => get_config('mod_jupyter', 'gradeservice_url'),
                'msg' => "{$e->getCode()}: {$e->getMessage()}"
                ]);
            } else {
                $error->errormessage = get_string('gradeservice_resp_err', 'jupyter');
            }
        } finally {
            $error->question = 0;
            $error->reached = 0;
            $error->max = 0;
            $error->error = true;
            array_push($points, $error);
            return $points;
        }

        foreach ($questions as $key => $entry) {
            $point = new stdClass;
            $point->question = $entry->questionnr;
            $point->reached = floatval($entry->points);
            $point->max = floatval(
                $DB->get_record(
                    'jupyter_questions',
                    array('jupyter' => $instanceid, 'questionnr' => $entry->questionnr),
                    'maxpoints', MUST_EXIST)->maxpoints
            );
            array_push($points, $point);
        }
            return $points;
    }

    /**
     * Returns description of return values.
     * @return external_multiple_structure
     */
    public static function execute_returns() {
        return new external_multiple_structure(
            new external_single_structure([
            'question' => new external_value(PARAM_RAW, 'question number in notebook'),
            'reached' => new external_value(PARAM_RAW, 'reached points in question after grading'),
            'max' => new external_value(PARAM_RAW, 'maximum reachable points in question'),
            'error' => new external_value(PARAM_BOOL, VALUE_OPTIONAL, 'if an error occured'),
            'errormessage' => new external_value(PARAM_RAW, VALUE_OPTIONAL, 'what error occured'),
            ]));
    }
}
