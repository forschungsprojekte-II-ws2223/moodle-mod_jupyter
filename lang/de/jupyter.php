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
 * german plugin strings are defined here.
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
$string['jupytername_help'] = 'Hilfe';
$string['jupytername'] = 'Jupyter Notebook Name'; // Name of the activity module instance.
$string['jupytersettings'] = 'Standard Einstellungen';
$string['jupyterfieldset'] = '';
$string['repourl'] = 'Git Repository URL';
$string['branch'] = 'Branch';
$string['file'] = 'Zu öffnende Notebook-Datei';

$string['jupyter:addinstance'] = 'Eine neue Jupyter-Aktivität hinzufügen';

$string['errorheading'] = '<strong>Error</strong><br>Entschuldiguen Sie, Ihr Jupyter Notebook (<i>"{$a->instancename}"</i>) konnte nicht geladen werden.<br>Bitte versuchen Sie, einen Administrator zu kontaktieren.';

$string['adminsettingserror'] = '<strong>Ursache:</strong> Die angegebene URL (<i>"{$a->url}"</i>) ist nicht verfügbar or führt nicht zu einem JupyterHub.<br>Prüfen Sie bitte die<i>Admin Einstellungen</i> und stellen Sie sicher, dass die URL mit der URL Ihres JupyterHub übereinstimmt.';

$string['instancesettingserror'] = '<strong>Ursache:</strong> Die angegebene Git Repository URL (<i>"{$a->url}"</i>) ist nicht verfügbar or führt nicht zu einer Jupyter-Notebook-Datei.<br>Prüfen Sie bitte die <i>Aktivitäts Einstellungen</i>  stellen Sie sicher, dass <i>Git Repository URL</i>, <i>Branch</i> und <i>Zu öffnende Notebook-Datei</i> korrekt eingetragen wurden.';

$string['resetbuttontext'] = 'Zurücksetzen';
$string['resetbuttoninfo'] = 'Um das Notebook in den ursprünglichen Zustand zurückzusetzen, ohne den Fortschritt zu verlieren, können Sie Ihre Änderungen in einer anderen Datei speichern, indem Sie auf <b>"File"</b> in der oberen linken Ecke klicken und <b>"Notebook speichern als..."</b> auswählen. Danach muss das bisherige Notebook gelöscht werden und dann der <b>"Zurücksetzen"</b> Button geklickt werden';

// Admin plugin settings.
// General.
$string['generalconfig'] = 'Allgemeine Einstellungen';
$string['generalconfig_desc'] = 'Notwendige Einstellungen, um das JupyterHub zu erreichen, das von dem Plugin verwendet wird.';
// URL.
$string['jupyterurl'] = 'JupyterHub URL';
$string['jupyterurl_desc'] = 'Fügen Sie hier die URL Ihres JupyterHub ein.<br>Muss eine gültige URL sein (z. B. https://yourjupyterhub.com).';
// JWT.
$string['jupytersecret'] = 'Jupyterhub JWT Secret';
$string['jupytersecret_desc'] = 'Fügen Sie hier das JWT-Geheimnis Ihres JupyterHub ein. <br><strong>Stellen Sie sicher, dass Ihr JupyterHub ein sicheres 256-Bit-Geheimnis verwendet!!!</strong>';
