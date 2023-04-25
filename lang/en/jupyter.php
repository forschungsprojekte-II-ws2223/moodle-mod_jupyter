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
 * @copyright   KIB3 StuPro SS2022 Uni Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Jupyter Notebook';
$string['modulenameplural'] = '';
$string['modulename'] = 'Jupyter Notebook';
$string['pluginadministration'] = 'pluginadministration';
$string['jupytername_help'] = 'Help text';
$string['jupytername'] = 'Jupyter Notebook Name'; // Name of the activity module instance.
$string['jupytersettings'] = 'Standard settings';
$string['jupyterfieldset'] = '';
$string['repourl'] = 'Git Repository URL';
$string['branch'] = 'Branch';
$string['file'] = 'Notebook file to open';
$string['package'] = 'Notebook file to open';
$string['package_help'] = 'Add the notbook file that will be displayed in the activity here.';
$string['areapackage'] = 'Package file';
$string['contentheader'] = 'Content';

$string['jupyter:addinstance'] = 'Add a new Jupyter Notebook activity';
$string['jupyter:view'] = 'View a Jupyter Notebook activity';
$string['jupyter:viewerrordetails'] = 'View extended information on errors occurring in the Jupyter Notebook activity';


$string['errorheading'] = '<strong>Error</strong><br>Sorry, your Jupyter Notebook (<i>"{$a->instancename}"</i>) could not be loaded due to a connection issue.';

$string['adminsettingserror'] = '<strong>Cause:</strong> The provided URL (<i>"{$a->url}"</i>) is not available or does not lead to a JupyterHub.<br>Check the <i>Admin Settings</i> and make sure the URL matches the URL of your JupyterHub.';

$string['instancesettingserror'] = '<strong>Cause:</strong> The provided Git Repository URL (<i>"{$a->url}"</i>) is not available or does not lead to a Jupyter Notebook file.<br>Check the <i>Activity Settings</i>  and make sure <i>Git Repository URL</i>, <i>Branch</i> and <i>Notebook file to open</i> are set correctly.';

$string['resetbuttontext'] = 'Reset';
$string['resetbuttoninfo'] = 'To get the original Notebook without losing progress, you can save your changes to a different file by clicking on <b>"File"</b> in the top left corner and then select <b>"Save Notebook As..."</b>. Afterwards,you need to <b>delete</b> the original file and click the <b>"Reset"</b> button.';

// Admin plugin settings.
// General.
$string['generalconfig'] = 'General settings';
$string['generalconfig_desc'] = 'Settings required to reach the JupyterHub this plugin uses.';
// Jupyterhub URL.
$string['jupyterhub_url'] = 'JupyterHub URL';
$string['jupyterhub_url_desc'] = 'Add the URL of your JupyterHub here.<br>Must be a valid URL (e.g. https://yourjupyterhub.com).';
// Jupyterhub JWT Token.
$string['jupyterhub_jwt_secret'] = 'Jupyterhub JWT Secret';
$string['jupyterhub_jwt_secret_desc'] = 'Add the JWT secret of your JupyterHub here.<br><strong>Make sure your JupyterHub is using a secure 256-bit secret!!!</strong>';
// JupyterHub API Token.
$string['jupyterhub_api_token'] = 'Jupyterhub API Token';
$string['jupyterhub_api_token_desc'] = 'Add the API token of your JupyterHub here. <br><strong>Make sure your JupyterHub is using a secure 256-bit token!!!</strong>';

