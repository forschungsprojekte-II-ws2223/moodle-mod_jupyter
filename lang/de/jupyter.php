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
$string['jupytername'] = 'Jupyter Notebook Name';
$string['jupytersettings'] = 'Standard Einstellungen';
$string['jupyterfieldset'] = '';
$string['package'] = 'Notebook-Datei';
$string['package_help'] = 'Laden sie hier die Notebook-Datei für die Aktivität hoch.';

$string['jupyter:addinstance'] = 'Eine neue Jupyter Notbook Aktivität hinzufügen';
$string['jupyter:view'] = 'Eine Jupyter Notebook Aktivität anzeigen';
$string['jupyter:viewerrordetails'] = 'Anzeige erweiterter Informationen zu Fehlern, die in der Jupyter Notebook Aktivität auftreten';

$string['resetbuttontext'] = 'Zurücksetzen';
$string['resetbuttoninfo'] = 'Um das Notebook in den ursprünglichen Zustand zurückzusetzen, ohne den Fortschritt zu verlieren, können Sie Ihre Änderungen in einer anderen Datei speichern, indem Sie auf <b>"File"</b> in der oberen linken Ecke klicken und <b>"Notebook speichern als..."</b> auswählen. Danach muss das bisherige Notebook gelöscht werden und dann der <b>"Zurücksetzen"</b> Button geklickt werden';

// Jupyterhub Errors.
$string['notebook_err'] = 'TODO';
$string['jupyter_connecterr'] = '<strong>Error: Jupyter Notebook konnte nicht geladen werden</strong><br>Entschuldiguen Sie, Ihr Jupyter Notebook konnte aufgrund eines Verbindungsproblems nicht geladen werden.<br> Bitte versuchen Sie, die Seite neu zu laden, um das Problem zu beheben. Wenn der Fehler weiterhin besteht, wenden Sie sich bitte an Ihren Lehrer oder Administrator, um das Problem zu lösen.';
$string['jupyter_connecterr_admin'] = '<strong>Error: Konnte keine Verbindung zu JupyterHub unter der URL (<i>"{$a->url}"</i>) herstellen.</strong><br>Stellen Sie sicher, dass Ihr JupyterHub läuft und unter der angegebenen URL verfügbar ist.<br>Sie können die JupyterHub URL in den Verwaltungseinstellungen des Plugins ändern.<br>Message: "{$a->msg}"';

// Gradeservice Errors.
$string['assignment_err'] = 'TODO';
$string['assignment_err_admin'] = 'TODO';
$string['gradeservice_connecterr_admin'] = '<strong>Error: Konnte keine Verbindung zur Gradeservie API unter der URL (<i>"{$a->url}"</i>) herstellen.</strong><br>Stellen Sie sicher, dass die Gradeservice API läuft und unter der angegebenen URL verfügbar ist.<br>Sie können die Gradeservice URL in den Verwaltungseinstellungen des Plugins ändern.<br>Message: "{$a->msg}"';

// Plugin admin settings.
$string['generalconfig'] = 'Allgemeine Einstellungen';
$string['generalconfig_desc'] = 'Notwendige Einstellungen, um das JupyterHub zu erreichen, das von dem Plugin verwendet wird.';
$string['jupyterhub_url'] = 'JupyterHub URL';
$string['jupyterhub_url_desc'] = 'Fügen Sie hier die URL Ihres JupyterHub ein.<br>Muss eine gültige URL sein (z. B. https://yourjupyterhub.com).';
$string['gradeservice_url'] = 'Gradeservice URL';
$string['gradeservice_url_desc'] = 'Fügen Sie hier die URL der Gradeservie API ein.';
$string['jupyterhub_jwt_secret'] = 'Jupyterhub JWT Secret';
$string['jupyterhub_jwt_secret_desc'] = 'Fügen Sie hier das JWT-Geheimnis Ihres JupyterHub ein. <br><strong>Stellen Sie sicher, dass Ihr JupyterHub ein sicheres 256-Bit-Geheimnis verwendet!!!</strong>';
$string['jupyterhub_api_token'] = 'Jupyterhub API Token';
$string['jupyterhub_api_token_desc'] = 'Fügen Sie hier den API Token Ihres JupyterHub ein. <br><strong>Stellen Sie sicher, dass Ihr JupyterHub einen sicheren 256-Bit-Token verwendet!!!</strong>';
