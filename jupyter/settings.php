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
 * Plugin administration pages are defined here.
 *
 * @package     mod_jupyter
 * @category    admin
 * @copyright   2022 onwards, University of Stuttgart(StuPro 2022)
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    if ($ADMIN->fulltree) {
        // Defines the plugin settings page - {@link https://docs.moodle.org/dev/Admin_settings}.

        $settings->add(new admin_setting_heading('jupyter_settings_heading', get_string('generalconfig', 'jupyter'),
            get_string('generalconfig_desc', 'jupyter')));

        // To use a settings value in code, use 'get_config('mod_jupyter', 'settingname'); !
        // e.g. $value = get_config('mod_jupyter', 'jupyterurl'); returns the URL.

        // Jupyter URL setting!
        $settings->add(new admin_setting_configtext('mod_jupyter/jupyterurl', get_string('jupyterurl', 'jupyter'),
            get_string('jupyterurl_desc', 'jupyter'), '', PARAM_URL));

        // Jupyter IP setting!
        $settings->add(new admin_setting_configtext('mod_jupyter/jupyterip', get_string('jupyterip', 'jupyter'),
            get_string('jupyterip_desc', 'jupyter'), '127.0.0.1', PARAM_HOST));

        // Jupyter port setting!
        $settings->add(new admin_setting_configtext('mod_jupyter/jupyterport', get_string('jupyterport', 'jupyter'),
            get_string('jupyterport_desc', 'jupyter'), 8000, PARAM_INT));

    }
}
