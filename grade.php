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

require(__DIR__.'/../../config.php');

// Course module ID.
$id = required_param('id', PARAM_INT);

$cm = get_coursemodule_from_id('jupyter', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('jupyter', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);

// Item number may be != 0 for activities that allow more than one grade per user.
$itemnumber = optional_param('itemnumber', 0, PARAM_INT);

// Graded user ID (optional).
$userid = optional_param('userid', 0, PARAM_INT);

// In the simplest case just redirect to the view page.
redirect('view.php?id='.$id);
