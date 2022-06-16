<?php

/**
 * @author Phillip Wohlfart
 * @author Raphael Weber
 * @author Solveigh König
 * @author Robin Klass
 * @date 31.05.2022
 * 
 */

require_once (__DIR__ .'/../../../config.php');
require_once($CFG->dirroot . '/mod/jupyter/ui/classes/buttons.php');

$PAGE->set_url(new moodle_url('/mod/jupyter/ui/manage.php'));
//there are different contexts. system wide in this context
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('UI skeleton');

$mform = new buttons();

$sections = ['Introduction', 'Learning', 'Institution', 'Another section', 'References'];

$templatecontext=[
    'sections'=>array_values($sections)
    ];


echo $OUTPUT->header();
echo $OUTPUT->render_from_template('mod_jupyter/logo',[]);
echo $OUTPUT->render_from_template('mod_jupyter/title',[]);
echo $OUTPUT->render_from_template('mod_jupyter/manage',$templatecontext);

// rather use custom buttons for now
// $mform->display();

echo $OUTPUT->footer();
