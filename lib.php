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
 * Library of interface functions and constants.
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Return if the plugin supports $feature.
 *
 * @param string $feature Constant representing the feature.
 * @return true | null True if the feature is supported, null otherwise.
 */
function jupyter_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
        case FEATURE_BACKUP_MOODLE2:
            return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return true;
        case FEATURE_GRADE_HAS_GRADE:
            return true;
        default:
            return null;
    }
}

/**
 * Saves a new instance of the mod_jupyter into the database.
 *
 * Given an object containing all the necessary data, (defined by the form
 * in mod_form.php) this function will create a new instance and return the id
 * number of the instance.
 *
 * @param object $data An object from the form.
 * @param mod_jupyter_mod_form $mform The form.
 * @return int The id of the newly inserted record.
 */
function jupyter_add_instance($data, $mform = null): int {
    global $DB;

    $data->timecreated = time();
    $data->timemodified = $data->timecreated;
    $cmid = $data->coursemodule;

    $data->id = $DB->insert_record('jupyter', $data);

    $DB->set_field('course_modules', 'instance', $data->id, ['id' => $cmid]);
    jupyter_set_mainfile($data);

    return $data->id;
}

/**
 * Updates an instance of the mod_jupyter in the database.
 *
 * Given an object containing all the necessary data (defined in mod_form.php),
 * this function will update an existing instance with new data.
 *
 * @param object $data An object from the form in mod_form.php.
 * @param mod_jupyter_mod_form $mform The form.
 * @return bool True if successful, false otherwise.
 */
function jupyter_update_instance($data, $mform = null) {
    global $DB;

    $data->timemodified = time();
    $data->id = $data->instance;

    jupyter_set_mainfile($data);

    return $DB->update_record('jupyter', $data);
}

/**
 * Removes an instance of the mod_jupyter from the database.
 *
 * @param int $id Id of the module instance.
 * @return bool True if successful, false on failure.
 */
function jupyter_delete_instance($id) {
    global $DB;

    $exists = $DB->get_record('jupyter', array('id' => $id));
    if (!$exists) {
        return false;
    }

    $DB->delete_records('jupyter', array('id' => $id));

    return true;
}

/**
 * Saves draft files as the activity package.
 *
 * @param stdClass $data an object from the form
 */
function jupyter_set_mainfile(stdClass $data): void {
    $fs = get_file_storage();
    $cmid = $data->coursemodule;
    $context = context_module::instance($cmid);

    if (!empty($data->packagefile)) {
        $fs = get_file_storage();
        $fs->delete_area_files($context->id, 'mod_jupyter', 'package');
        file_save_draft_area_files($data->packagefile, $context->id, 'mod_jupyter', 'package',
            0, ['subdirs' => 0, 'maxfiles' => 1]);
    }
}
