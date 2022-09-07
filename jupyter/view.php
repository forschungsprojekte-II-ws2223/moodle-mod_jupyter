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

require(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');
require(__DIR__ . '/vendor/autoload.php');

use Firebase\JWT\JWT;

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
$gitfilelink = gen_gitfilelink();

$gitreachable = check_url($gitfilelink)[0] === 200;
$jupyterreachable = check_jupyter($jupyterurl);

// Mark as done after user views the course
$completion = new completion_info($course);
$completion->set_module_viewed($cm);


echo $OUTPUT->header();

if ($gitreachable && $jupyterreachable) {
    echo $OUTPUT->render_from_template('mod_jupyter/manage', [
        'login' => $jupyterurl . gen_gitpath() . "&auth_token="  . $jwt,
        'name' => $name,
        'resetbuttontext' => get_string('resetbuttontext', 'jupyter'),
        'description' => get_string('resetbuttoninfo', 'jupyter')
    ]);
} else {
    show_error_message();
}

echo $OUTPUT->footer();

/**
 * Creates nbgitpuller part of the link to the JupyterHub.
 * @return string the formatted path and query parameters for nbgitpuller
 */
function gen_gitpath() : string {
    global $repo, $file, $branch;

    if (preg_match("/\/$/", "$repo")) {
        $repo = substr($repo, 0, strlen($repo) - 1);
    }

    return '/hub/user-redirect/git-pull?repo=' .
        urlencode($repo) .
        '&urlpath=lab%2Ftree%2F' .
        urlencode(substr(strrchr($repo, "/"), 1)) .
        '%2F' .
        $file .
        '&branch=' .
        $branch;
}

/**
 * Generates link to file in git repository
 * @return string example: https://github.com/username/reponame/blob/branch/notebook.ipynb
 */
function gen_gitfilelink() : string {
    global $repo, $file, $branch;

    if (preg_match("/\/$/", "$repo")) {
        $repo = substr($repo, 0, strlen($repo) - 1);
    }

    return $repo . "/blob/" . $branch . "/" . $file;
}

/**
 * Checks if JupyterHub is reachable
 * @param string $url
 * @return bool
 */
function check_jupyter(string $url) : bool {
    $res = check_url($url);

    if ($res[0] !== 401 && strpos($url, "127.0.0.1") !== false) {
        $res = check_url(str_replace("127.0.0.1", "host.docker.internal", $url));
    }

    // Check if respose code matches and "x-jupyterhub-version" header is set in response header.
    // Response code should be 401 because we didnt pass an auth token.
    return $res[0] === 401 && $res[1] != "";
}

/**
 * Send HTTP request to URL and return response status code
 * @param string $url The URL to check for availability.
 * @return array Returns HTTP status code of the request and response header string
 */
function check_url(string $url) : array {
    $client = new GuzzleHttp\Client();
    try {
        $res = $client->get($url);
    } catch (GuzzleHttp\Exception\RequestException $e) {
        $res = $e->getResponse();
    } catch (GuzzleHttp\Exception\ConnectException $e) {
        return [0, ""];
    }

    return [
        $res->getStatusCode(),
        $res->getHeaderLine("x-jupyterhub-version")
    ];
}

/**
 * Shows different error messages depending on cause of error
 */
function show_error_message() {
    global $gitreachable, $jupyterreachable, $jupyterurl, $gitfilelink, $moduleinstance, $modulecontext;

    \core\notification::error(get_string('errorheading', 'jupyter', ['instancename' => $moduleinstance->name]));

    if (has_capability('mod/jupyter:viewerrordetails', $modulecontext)) {
        if (!$jupyterreachable) {
            \core\notification::error(get_string('adminsettingserror', 'jupyter', ['url' => $jupyterurl]));
        }
        if (!$gitreachable) {
            \core\notification::error(get_string('instancesettingserror', 'jupyter', ['url' => $gitfilelink]));
        }
    }

}
