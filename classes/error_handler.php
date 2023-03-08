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

use core\notification;

/**
 * Error handler.
 *
 * @package mod_jupyter
 */
class error_handler {
    /**
     * Shows different error messages depending on cause of error (instance/admin settings).
     */
    public static function show_error_message() {
        global $jupyterhuburl, $moduleinstance, $modulecontext;
        notification::error(get_string('errorheading', 'jupyter', ['instancename' => $moduleinstance->name]));

        if (has_capability('mod/jupyter:viewerrordetails', $modulecontext)) {
                notification::error(get_string('adminsettingserror', 'jupyter', ['url' => $jupyterhuburl]));
        }
    }

}
