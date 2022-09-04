<?php

/**
 * Define the complete jupyter structure for backup, with file and id annotations
 */
class backup_jupyter_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // To know if we are including userinfo
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated
        $jupyter = new backup_nested_element('jupyter', array('id'),
            array('course', 'name', 'timecreated', 'timemodified', 'intro', 'introformat', 'repourl', 'branch', 'file'));

        // Define sources
        $jupyter->set_source_table('jupyter', array('id' => backup::VAR_ACTIVITYID));

        // Define id annotations

        // Define file annotations

        // Return the root element (jupyter), wrapped into standard activity structure
        return $this->prepare_activity_structure($jupyter);

    }
}
