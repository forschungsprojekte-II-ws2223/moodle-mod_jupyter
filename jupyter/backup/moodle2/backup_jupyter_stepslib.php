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
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Define the complete jupyter structure for backup, with file and id annotations
 */
class backup_jupyter_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // To know if we are including userinfo
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated
        $jupyter = new backup_nested_element('jupyter', array('id'),
            array('course', 'name', 'timecreated', 'timemodified', 'intro', 'introformat', 'repourl', 'branch', 'file'));

        // Define sources
        $jupyter->set_source_table('jupyter', array('id' => backup::VAR_ACTIVITYID));

        // Define id annotations

        // Define file annotations
        $jupyter->annotate_files('mod_jupyter', 'intro', null);

        // Return the root element (jupyter), wrapped into standard activity structure
        return $this->prepare_activity_structure($jupyter);

    }
}
