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

use mod_jupyter\jupyterhub_handler;
use external_function_parameters;
use external_multiple_structure;
use external_single_structure;
use external_value;


/**
 * Jupyter web service class for resetting the notebook.
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class reset_notebook extends \external_api {
    /**
     * Returns description of method parameters.
     * @return external_function_parameters
     */
    public static function execute_parameters() {
        return new external_function_parameters([
            'user' => new external_value(PARAM_RAW, VALUE_REQUIRED, 'unique user id'),
            'contextid' => new external_value(PARAM_RAW, VALUE_REQUIRED, 'module context id'),
            'courseid' => new external_value(PARAM_RAW, VALUE_REQUIRED, 'module course id'),
            'instanceid' => new external_value(PARAM_RAW, VALUE_REQUIRED, 'module instance id')
        ]);
    }

    /**
     * Rename any naming collisions and reupload the default notebook.
     *
     * @param string $user current user's username
     * @param int $contextid contextid of activity instance
     * @param int $courseid course id
     * @param int $instanceid :)
     * @return string
     */
    public static function execute($user, $contextid, $courseid, $instanceid) {
        $handler = new jupyterhub_handler();
        $handler->reset_notebook($user, $contextid, $courseid, $instanceid);
        return 'notebook reset';
    }

    /**
     * Returns description of return values.
     * @return external_value
     */
    public static function execute_returns() {
        return new external_value(PARAM_TEXT, VALUE_REQUIRED, 'test value');
    }
}