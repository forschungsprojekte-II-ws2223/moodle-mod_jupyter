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

defined('MOODLE_INTERNAL') || die();

/**
 * Creates an instance of mod_jupyter for testing purpose.
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_jupyter_generator extends testing_module_generator {
    /**
     * Create new jupyter module instance
     *
     * @param array|stdClass $record
     * @param array $options
     * @return stdClass mod_jupyter_structure
     */
    public function create_instance($record = null, array $options = null) {
        global $USER, $CFG;
        require_once($CFG->dirroot . '/lib/resourcelib.php');
        $record = (object)(array)$record;

        if (!isset($record->name)) {
            $record->name = 'JupyterInstanceName';
        }
        // The 'files' value corresponds to the draft file area ID. If not
        // specified, create a default file.
        if (!isset($record->package)) {
            if (empty($USER->username) || $USER->username === 'guest') {
                throw new coding_exception('jupyter generator requires a current user');
            }
            $usercontext = context_user::instance($USER->id);
            $filename = $record->defaultfilename ?? 'jupyternotebook.ipynb';

            // Pick a random context id for specified user.
            $record->package = file_get_unused_draft_itemid();

            // Add actual file there.
            $filerecord = ['component' => 'user', 'filearea' => 'draft',
                    'contextid' => $usercontext->id, 'itemid' => $record->package,
                    'filename' => $filename, 'filepath' => '/'];
            $fs = get_file_storage();
            $fs->create_file_from_string($filerecord, 'Test resource ' . $filename . ' file');
        }
        return parent::create_instance($record, (array)$options);
    }
}
