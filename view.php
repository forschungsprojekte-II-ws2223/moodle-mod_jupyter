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

use Firebase\JWT\JWT;
use GuzzleHttp\Client;

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

// Create id with the user's unique username from Moodle.
$uniqueid = mb_strtolower($USER->username, "UTF-8");

$jwt = JWT::encode([
    "name" => $uniqueid,
    "iat" => time(),
    "exp" => time() + 15
], get_config('mod_jupyter', 'jupytersecret'), 'HS256');

$jupyterurl = get_config('mod_jupyter', 'jupyterurl');
$repo = $moduleinstance->repourl;
$branch = urlencode(trim($moduleinstance->branch));
$file = urlencode(trim($moduleinstance->file));
$name = $moduleinstance->name;
$gitfilelink = \mod_jupyter\helper::gen_gitfilelink($repo, $file, $branch);

$gitreachable = \mod_jupyter\helper::check_url($gitfilelink)[0] === 200;
$jupyterreachable = \mod_jupyter\helper::check_jupyter($jupyterurl);

// Mark as done after user views the course.
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

echo $OUTPUT->header();

if ($gitreachable && $jupyterreachable) {
    echo $OUTPUT->render_from_template('mod_jupyter/manage', [
        'login' => $jupyterurl . \mod_jupyter\helper::gen_gitpath($repo, $file, $branch) . "&auth_token=" . $jwt,
        'name' => $name,
        'resetbuttontext' => get_string('resetbuttontext', 'jupyter'),
        'description' => get_string('resetbuttoninfo', 'jupyter')
    ]);
} else {
    \mod_jupyter\helper::show_error_message($gitreachable, $jupyterreachable, $jupyterurl, $gitfilelink, $moduleinstance, $modulecontext);
}

echo $OUTPUT->footer();



