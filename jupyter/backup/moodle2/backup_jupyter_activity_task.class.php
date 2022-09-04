<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package   mod_jupyter
 * @copyright KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/jupyter/backup/moodle2/backup_jupyter_stepslib.php');
require_once($CFG->dirroot . '/mod/jupyter/backup/moodle2/backup_jupyter_settingslib.php');

/**
 * Backup task that provides all the settings and steps to perform one complete backup of the activity.
 */
class backup_jupyter_activity_task extends backup_activity_task {

    /**
     * Definition of particular settings this activity can have.
     */
    protected function define_my_settings() {
        // No particular settings for this activity
    }

    /**
     * Definition of particular steps this activity can have.
     */
    protected function define_my_steps() {
        $this->add_step(new backup_jupyter_activity_structure_step('jupyter_structure', 'jupyter.xml'));
    }


    /**
     * Transformations to perform in the activity in order to get transportable (encoded) links.
     *
     * @param $content
     *
     * @return array|string|string[]|null
     */
    public static function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, "/");

        // Link to the list of choices
        $search = "/(".$base."\/mod\/jupyter\/index.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@JUPYTERINDEX*$2@$', $content);

        // Link to choice view by moduleid
        $search = "/(".$base."\/mod\/jupyter\/view.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@JUPYTERVIEWBYID*$2@$', $content);

        return $content;
    }
}
