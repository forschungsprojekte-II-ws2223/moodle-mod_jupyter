<?php

/**
 * @author Phillip Wohlfart
 * @author Raphael Weber
 * @author Solveigh König
 * @author Robin Klass
 * @date 31.05.2022
 * 
 */

//moodleform is defined in formslib.php
require_once ("$CFG->libdir/formslib.php");

class buttons extends moodleform{
    public function definition() {
        global $CFG;
       
        $mform = $this->_form; // Don't forget the underscore! 

        // $mform->addElement('text', 'email', get_string('email')); // Add elements to your form.
        // $mform->setType('email', PARAM_NOTAGS);                   // Set type of element.
        // $mform->setDefault('email', 'Please enter email');        // Default value.

        $this->add_action_buttons(true);
    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}
