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
 * Definition of all the restore steps that will be used by the restore_choice_activity_task.
 *
 * @package   mod_jupyter
 * @copyright KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Class that provides all steps for restoring up the activity.
 */
class restore_jupyter_activity_structure_step extends restore_activity_structure_step {
    /**
     * Creation of the standard activity structure containing all information from the backup file.
     *
     * @return mixed
     */
    protected function define_structure() {

        $paths = array();

        $paths[] = new restore_path_element('jupyter', '/activity/jupyter');

        // Return the paths wrapped into standard activity structure.
        return $this->prepare_activity_structure($paths);
    }

    /**
     * Definition of how to get all needed information from the backup file.
     *
     * @param object $data
     *
     * @return void
     */
    protected function process_jupyter($data) {
        global $DB;

        $data = (object) $data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        // Insert the jupyter record.
        $newitemid = $DB->insert_record('jupyter', $data);
        // Immediately after inserting "activity" record, call this.
        $this->apply_activity_instance($newitemid);
    }

    /**
     * Add jupyter related files. There is no need to match by itemname (just internally handled context).
     *
     * @return void
     */
    protected function after_execute() {
        $this->add_related_files('mod_jupyter', 'intro', null);
    }
}
