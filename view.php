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
 * Prints an instance of mod_jupyter.
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
require(__DIR__ . '/vendor/autoload.php');

use core\notification;
use Firebase\JWT\JWT;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use mod_jupyter\error_handler;
use mod_jupyter\jupyterhub_handler;
use mod_jupyter\gradeservice_handler;

// Moodle specific config.
global $DB, $PAGE, $USER, $OUTPUT;

// Course module id.
$id = optional_param('id', 0, PARAM_INT);

// Activity instance id.
$j = optional_param('j', 0, PARAM_INT);

if ($id) {
    $cm = get_coursemodule_from_id('jupyter', $id, 0, false, MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $moduleinstance = $DB->get_record('jupyter', array('id' => $cm->instance), '*', MUST_EXIST);
} else {
    $moduleinstance = $DB->get_record('jupyter', array('id' => $j), '*', MUST_EXIST);
    $course = $DB->get_record('course', array('id' => $moduleinstance->course), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('jupyter', $moduleinstance->id, $course->id, false, MUST_EXIST);
}

require_login($course, true, $cm);

$modulecontext = context_module::instance($cm->id);

$PAGE->set_url('/mod/jupyter/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($moduleinstance->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);

// User interface.
$jupyterhuburl = get_config('mod_jupyter', 'jupyterhub_url');

echo $OUTPUT->header();

$user = mb_strtolower($USER->username, "UTF-8"); // Create id with the user's unique username from Moodle.

$handler = new jupyterhub_handler($user, $modulecontext->id);
$ghandler = new gradeservice_handler();

try {
    $ghandler->create_assignment($course->id, $modulecontext->id);
} catch (RequestException $e) {
    if ($e->hasResponse()) {
        notification::error("{$e->getResponse()->getBody()->getContents()}");
    } else {
        notification::error("{$e->getCode()}: {$e->getMessage()}");
    }
} catch (ConnectException $e) {
    notification::error("{$e->getCode()}: {$e->getMessage()}");
}

try {
    $notebookpath = $handler->get_notebook_path();

    $jwt = JWT::encode([
        "name" => $user,
        "iat" => time(),
        "exp" => time() + 15
    ], get_config('mod_jupyter', 'jupyterhub_jwt_secret'), 'HS256');

    echo $OUTPUT->render_from_template('mod_jupyter/manage', [
        'login' => $jupyterhuburl . $notebookpath . "?auth_token=" . $jwt,
        'resetbuttontext' => get_string('resetbuttontext', 'jupyter'),
        'description' => get_string('resetbuttoninfo', 'jupyter')
    ]);
} catch (RequestException $e) {
    if ($e->hasResponse()) {
        notification::error("{$e->getResponse()->getBody()->getContents()}");
    } else {
        notification::error("{$e->getCode()}: {$e->getMessage()}");
    }
} catch (ConnectException $e) {
    error_handler::show_error_message();
}

// Mark as done after user views the course.
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

echo $OUTPUT->footer();



