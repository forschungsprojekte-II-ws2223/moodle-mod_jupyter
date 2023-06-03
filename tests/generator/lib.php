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
        global $CFG, $SITE;
        require_once($CFG->dirroot . '/lib/resourcelib.php');
        $record = (object)(array)$record;

        if (!isset($record->name)) {
            $record->name = 'JupyterInstanceName';
        }

        $content = 'abcd';
        $filerecord = array(
            'contextid' => $SITE->id,
            'component' => 'mod_jupyter',
            'filearea'  => 'package',
            'itemid'    => $this->instancecount,
            'filepath'  => '/',
            'filename'  => 'testfile' . ($this->instancecount + 1) .'.ipynb',
        );

        $filerecord2 = array(
            'contextid' => $SITE->id,
            'component' => 'mod_jupyter',
            'filearea'  => 'assignment',
            'itemid'    => $this->instancecount,
            'filepath'  => '/',
            'filename'  => 'testfile' . ($this->instancecount + 1) .'.ipynb',
        );

        $fs = get_file_storage();
        $fs->create_file_from_string($filerecord, $content);
        $fs->create_file_from_string($filerecord2, $content);

        return parent::create_instance($record, (array)$options);
    }
}
