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
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/moodleform_mod.php');

/**
 * Module instance settings form.
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
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

        // Adding the radio button for switching between the filemanager and the git reository.
        $radioarray = array();
        $radioarray[] = $mform->createElement('radio', 'toggle_input', '', get_string('package_radio', 'mod_jupyter'), 0, '');
        $radioarray[] = $mform->createElement('radio', 'toggle_input', '', get_string('git_radio', 'mod_jupyter'), 1, '');
        $mform->addGroup($radioarray, 'radioar', '', array(' '), false);

        // Adding file manager for jupyter notebook file.
        $mform->addElement('filemanager', 'packagefile', get_string('package', 'mod_jupyter'), null, [
            'accepted_types' => '.ipynb',
            'maxbytes' => 0,
            'maxfiles' => 1,
            'subdirs' => 0,
        ]);
        $mform->addHelpButton('packagefile', 'package', 'mod_jupyter');

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }

        // Setting rules for the input fields above.
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'jupytername', 'mod_jupyter');

        // Adding fields for notebook git repository.
        $mform->addElement('text', 'repourl', get_string('repourl', 'mod_jupyter'), array('size' => '64'));
        $mform->addElement('text', 'branch', get_string('branch', 'mod_jupyter'), array('size' => '64'));
        $mform->addElement('text', 'file', get_string('file', 'mod_jupyter'), array('size' => '64'));

        // Setting rules for the git input fields.
        $urlregex = "/(^(https?:\/\/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})\:?([0-9]{1,5})?$)"
            . "|(^((https?:\/\/)|^(www\.))"
            . "([a-zA-Z0-9\?\/\+\*\~\=\-\#\@\!\&\%\_\.]+\.[a-z]{2,4})(\/[a-zA-Z0-9\?\/\+\*\~\=\-\#\@\!\&\%\_]*)*$)/";

        $mform->addRule('repourl', "Must be a valid git URL", 'regex', $urlregex, 'client');
        $mform->addRule('repourl', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addRule('branch', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addRule('file', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

        // Adding the script for toggling between file manager and text input elements.
        $mform->hideIf('repourl', 'toggle_input', 'eq', 0);
        $mform->hideIf('branch', 'toggle_input', 'eq', 0);
        $mform->hideIf('file', 'toggle_input', 'eq', 0);
        $mform->hideIf('packagefile', 'toggle_input', 'eq', 1);

        // Adding the standard "intro" and "introformat" fields.
        $this->standard_intro_elements();

        // Add standard elements.
        $this->standard_coursemodule_elements();

        // Add standard buttons.
        $this->add_action_buttons();
    }

    /**
     * Enforce validation rules here
     *
     * @param array $data array of ("fieldname"=>value) of submitted data
     * @param array $files array of uploaded files "element_name"=>tmp_file_path
     * @return array
     **/
    public function validation($data, $files) {
        global $USER;
        $errors = parent::validation($data, $files);

        if (empty($data['packagefile'])) {
            $errors['packagefile'] = get_string('required');

        } else {
            $draftitemid = file_get_submitted_draft_itemid('packagefile');

            file_prepare_draft_area($draftitemid, $this->context->id, 'mod_jupyter', 'packagefilecheck', null,
                ['subdirs' => 0, 'maxfiles' => 1]);

            // Get file from users draft area.
            $usercontext = context_user::instance($USER->id);
            $fs = get_file_storage();
            $files = $fs->get_area_files($usercontext->id, 'user', 'draft', $draftitemid, 'id', false);

            if (count($files) < 1) {
                $errors['packagefile'] = get_string('required');
                return $errors;
            }
            $file = reset($files);
            if (!$file->is_external_file() && !empty($data['updatefreq'])) {
                // Make sure updatefreq is not set if using normal local file.
                $errors['updatefreq'] = get_string('updatefreq_error', 'mod_jupyter');
            }
        }

        return $errors;
    }

    /**
     * Enforce defaults here.
     *
     * @param array $defaultvalues From defaults
     * @return void
     */
    public function data_preprocessing(&$defaultvalues) {

        // Load existing notebook file into file manager draft area.
        $draftitemid = file_get_submitted_draft_itemid('packagefile');
        file_prepare_draft_area($draftitemid, $this->context->id, 'mod_jupyter',
            'package', 0, ['subdirs' => 0, 'maxfiles' => 1]);
        $defaultvalues['packagefile'] = $draftitemid;

    }
}
