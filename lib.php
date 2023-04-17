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

/**
 * Lists all browsable file areas
 *
 * @package  mod_jupyter
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @return array
 */
function jupyter_get_file_areas($course, $cm, $context) {
    $areas = array();
    $areas['content'] = get_string('jupytercontent', 'jupyter');

    return $areas;
}


/**
 * Serves the jupyter files.
 *
 * @package  mod_jupyter
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool false if file not found, does not return if found - just send the file
 */
function jupyter_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $CFG, $DB;

    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    require_course_login($course, true, $cm);
    if (!has_capability('mod/jupyter:view', $context)) {
        return false;
    }

    if ($filearea !== 'content') {
        // intro is handled automatically in pluginfile.php
        return false;
    }

    array_shift($args); // ignore revision - designed to prevent caching problems only

    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = "/$context->id/mod_jupyter/content/0/$relativepath";
    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        return false;
    }

    // Set security posture for in-browser display.
    if (!$forcedownload) {
        header("Content-Security-Policy: default-src 'none'; img-src 'self'");
    }

    // Finally send the file.
    send_stored_file($file, 0, 0, $forcedownload, $options);
}


/**
 * Export jupyter resource contents
 *
 * @return array of file content
 */
function jupyter_export_contents($cm, $baseurl) {
    global $CFG, $DB;
    $contents = array();
    $context = context_module::instance($cm->id);
    $jupyter = $DB->get_record('jupyter', array('id'=>$cm->instance), '*', MUST_EXIST);

    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'mod_jupyter', 'content', 0, 'sortorder DESC, id ASC', false);

    foreach ($files as $fileinfo) {
        $file = array();
        $file['type'] = 'file';
        $file['filename']     = $fileinfo->get_filename();
        $file['filepath']     = $fileinfo->get_filepath();
        $file['filesize']     = $fileinfo->get_filesize();
        $file['fileurl']      = file_encode_url("$CFG->wwwroot/" . $baseurl, '/'.$context->id.'/mod_jupyter/content/'.$jupyter->revision.$fileinfo->get_filepath().$fileinfo->get_filename(), true);
        $file['timecreated']  = $fileinfo->get_timecreated();
        $file['timemodified'] = $fileinfo->get_timemodified();
        $file['sortorder']    = $fileinfo->get_sortorder();
        $file['userid']       = $fileinfo->get_userid();
        $file['author']       = $fileinfo->get_author();
        $file['license']      = $fileinfo->get_license();
        $file['mimetype']     = $fileinfo->get_mimetype();
        $file['isexternalfile'] = $fileinfo->is_external_file();
        if ($file['isexternalfile']) {
            $file['repositorytype'] = $fileinfo->get_repository_type();
        }
        $contents[] = $file;
    }

    return $contents;
}
