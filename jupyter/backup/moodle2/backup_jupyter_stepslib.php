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
 * Definition for the complete jupyter structure for backup, with file and id annotations.
 *
 * @package   mod_jupyter
 * @copyright KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class backup_jupyter_activity_structure_step extends backup_activity_structure_step {


    /**
     * Definition of the structure of the backup file.
     *
     * @return mixed
     */
    protected function define_structure() {

        // Define each element separated
        $jupyter = new backup_nested_element('jupyter', array('id'),
            array('course', 'name', 'timecreated', 'timemodified', 'intro', 'introformat', 'repourl', 'branch', 'file'));

        // Define sources
        $jupyter->set_source_table('jupyter', array('id' => backup::VAR_ACTIVITYID));

        // Define file annotations
        $jupyter->annotate_files('mod_jupyter', 'intro', null);

        // Return the root element (jupyter), wrapped into standard activity structure
        return $this->prepare_activity_structure($jupyter);

    }
}
