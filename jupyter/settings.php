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
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
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

        $urlregex = "/(^(https?:\/\/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})\:?([0-9]{1,5})?$)"
        . "|"
        . "(^((https?:\/\/)|^(www\.))([a-zA-Z0-9\?\/\+\*\~\=\-\#\@\!\&\%\_\.]+\.[a-z]{2,4})(\/[a-zA-Z0-9\?\/\+\*\~\=\-\#\@\!\&\%\_]*)*$)/";

        $settings->add(new admin_setting_configtext('mod_jupyter/jupyterurl', get_string('jupyterurl', 'jupyter'),
            get_string('jupyterurl_desc', 'jupyter'), null, $urlregex));

        $settings->add(new admin_setting_configpasswordunmask('mod_jupyter/jupytersecret', get_string('jupytersecret', 'jupyter'),
            get_string('jupytersecret_desc', 'jupyter'), 'your-256-bit-secret'));
    }
}
