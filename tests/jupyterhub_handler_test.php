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

namespace mod_jupyter;

/**
 * Test cases for jupyterhub_handler.
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class jupyterhub_handler_test extends \advanced_testcase {
    /**
     * Test constructor.
     * @covers \jupyterhub_handler
     * @return void
     */
    public function test_constructor() {
        global $USER, $OUTPUT, $CFG, $DB, $SITE, $moduleinstance, $modulecontext;
        $this->resetAfterTest();
        $this->setAdminUser();
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_jupyter');
        $jupyter = $generator->create_instance(array('course' => $SITE->id));
        $cm = get_coursemodule_from_instance('jupyter', $jupyter->id);
        $moduleinstance = $DB->get_record('jupyter', array('id' => $cm->instance), '*', MUST_EXIST);
        $modulecontext = \context_module::instance($cm->id);
        set_config('jupyterhub_url', 'testuri', 'mod_jupyter');
        $jupyterhuburl = get_config('mod_jupyter', 'jupyterhub_url');
        $user = mb_strtolower($USER->username, "UTF-8");
        $handler = new jupyterhub_handler($user, $modulecontext->id);
        $this->assertEquals(property_exists($handler, 'user'), true);
        $this->assertEquals(property_exists($handler, 'contextid'), true);
        $this->assertEquals(property_exists($handler, 'client'), true);
    }
        /**
         * Test if notebookpath gets returned correctly.
         * @covers \jupyterhub_handler
         * @return void
         */
    public function test_get_notebook_path() {
        global $USER, $OUTPUT, $CFG, $DB, $SITE, $moduleinstance, $modulecontext;
        $this->resetAfterTest();
        $this->setAdminUser();
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_jupyter');
        $jupyter = $generator->create_instance(array('course' => $SITE->id));
        $cm = get_coursemodule_from_instance('jupyter', $jupyter->id);
        $moduleinstance = $DB->get_record('jupyter', array('id' => $cm->instance), '*', MUST_EXIST);
        $modulecontext = \context_module::instance($cm->id);
        set_config('jupyterhub_url', 'http://127.0.0.1:8000', 'mod_jupyter');
        $jupyterhuburl = get_config('mod_jupyter', 'jupyterhub_url');
        $user = mb_strtolower($USER->username, "UTF-8");
        $handler = new jupyterhub_handler($user, $SITE->id);
        $fs = get_file_storage();
        $files = $fs->get_area_files($SITE->id, 'mod_jupyter', 'package', 0, 'id', false);
        $this->assertCount(1, $files);
        $notebookpath = $handler->get_notebook_path();
        // Check $notebookpath correct.
        $this->assertEquals($notebookpath, '/hub/user-redirect/lab/tree/work/testfile1.ipynb');
    }
}
