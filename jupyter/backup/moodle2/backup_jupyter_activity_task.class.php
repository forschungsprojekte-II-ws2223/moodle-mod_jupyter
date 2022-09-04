<?php
require_once($CFG->dirroot . '/mod/jupyter/backup/moodle2/backup_jupyter_stepslib.php');
require_once($CFG->dirroot . '/mod/jupyter/backup/moodle2/backup_jupyter_settingslib.php');

/**
 * backup task that provides all the settings and steps to perform one
 * complete backup of the activity
 */
class backup_jupyter_activity_task extends backup_activity_task {

    /**
     * Define (add) particular settings this activity can have
     */
    protected function define_my_settings() {
        // No particular settings for this activity
    }

    /**
     * Define (add) particular steps this activity can have
     */
    protected function define_my_steps() {
        $this->add_step(new backup_jupyter_activity_structure_step('jupyter_structure', 'jupyter.xml'));
    }

    /**
     * Code the transformations to perform in the activity in
     * order to get transportable (encoded) links
     */
    public static function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot,"/");

        // Link to the list of choices
        $search="/(".$base."\/mod\/jupyter\/index.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@JUPYTERINDEX*$2@$', $content);

        // Link to choice view by moduleid
        $search="/(".$base."\/mod\/jupyter\/view.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@JUPYTERVIEWBYID*$2@$', $content);

        return $content;
    }
}
