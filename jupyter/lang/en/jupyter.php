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
 * Plugin strings are defined here.
 *
 * @package     mod_jupyter
 * @category    string
 * @copyright   2022 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Jupyter Hub';
$string['modulenameplural'] = '';
$string['modulename'] = 'Jupyter Hub';
$string['pluginadministration'] = 'pluginadministration';
$string['jupytername_help, mod_jupyter'] = 'Help text';
$string['jupytername'] = 'Jupyter Name'; //Name of the activity module instance
$string['jupytersettings'] = 'Standard settings';
$string['jupyterfieldset'] = '';

$string['jupyter:addinstance'] = 'Add a new Jupyter Activity';

//Admin plugin settings
//URL
$string['jupyter_url'] = 'Jupyter URL';
$string['jupyter_url_desc'] = 'Add the URL to your jupyter hub. Http://localhost/ is not accepted but
* http://localhost.localdomain/ is ok.';
//IP
$string['jupyter_ip'] = 'Jupyter IP';
$string['jupyter_ip_desc'] = 'Add the ip to your jupyter hub. IPv4 dotted quad (IP address).';
//Port
$string['jupyter_port'] = 'Jupyter Port';
$string['jupyter_port_desc'] = 'Add the port your jupyter runs on.';
