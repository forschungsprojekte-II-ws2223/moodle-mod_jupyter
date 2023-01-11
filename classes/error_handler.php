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

class error_handler {
    /**
     * Shows different error messages depending on cause of error
     */
    public static function show_error_message($gitreachable, $jupyterreachable, $jupyterurl, $gitfilelink, $moduleinstance, $modulecontext) {
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

}
