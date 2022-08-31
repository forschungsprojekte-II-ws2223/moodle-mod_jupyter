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
 * The main mod_jupyter configuration form.
 *
 * @package     mod_jupyter
 * @copyright   2022 onwards, University of Stuttgart(StuPro 2022)
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form.
 *
 * @package     mod_jupyter
 * @copyright   2022 onwards, University of Stuttgart(StuPro 2022)
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_jupyter_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        // Adding the "general" fieldset, where all the common settings are shown.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field.
        $mform->addElement('text', 'name', get_string('jupytername', 'mod_jupyter'), array('size' => '64'));

        // Adding fields for notebook git repository.
        $mform->addElement('text', 'repourl', get_string('repourl', 'mod_jupyter'), array('size' => '64'));
        $mform->addElement('text', 'branch', get_string('branch', 'mod_jupyter'), array('size' => '64'));
        $mform->addElement('text', 'file', get_string('file', 'mod_jupyter'), array('size' => '64'));

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
            $mform->setType('repourl', PARAM_URL);
            $mform->setType('branch', PARAM_TEXT);
            $mform->setType('file', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
            $mform->setType('repourl', PARAM_CLEANHTML);
            $mform->setType('branch', PARAM_CLEANHTML);
            $mform->setType('file', PARAM_CLEANHTML);
        }

        // Setting rules for the input fields above.
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'jupytername', 'mod_jupyter');

        $mform->addRule('repourl', null, 'required', null, 'client');
        $regex = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
        $mform->addRule('repourl', "Must be a valid git URL", 'regex', $regex, 'client');
        $mform->addRule('repourl', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

        $mform->addRule('branch', null, 'required', null, 'client');
        $mform->addRule('branch', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

        $mform->addRule('file', null, 'required', null, 'client');
        $mform->addRule('file', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

        // Adding the standard "intro" and "introformat" fields.
        if ($CFG->branch >= 29) {
            $this->standard_intro_elements();
        } else {
            $this->add_intro_editor();
        }

        // Add standard elements.
        $this->standard_coursemodule_elements();

        // Add standard buttons.
        $this->add_action_buttons();
    }
}

