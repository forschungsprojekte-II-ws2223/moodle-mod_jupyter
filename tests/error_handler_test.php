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

defined('MOODLE_INTERNAL') || die();

use core\notification;
use ReflectionClass;
/**
 * Test cases for error message creation in view.php if settings are not correct.
 * Depending on current user capabilities show error message:
 * Admin - heading and detailed info.
 * Non admin - only heading.
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class error_handler_test extends \advanced_testcase {
    /**
     * Test if two errors (heading and details) are created if user is an admin.
     * @covers \error_handler
     * @return void
     */
    public function test_error_is_created_admin() {
        global $OUTPUT, $CFG, $DB, $SITE, $moduleinstance, $modulecontext;
        $this->resetAfterTest();
        $this->setAdminUser();
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_jupyter');
        $jupyter = $generator->create_instance(array('course' => $SITE->id));
        $cm = get_coursemodule_from_instance('jupyter', $jupyter->id);
        $moduleinstance = $DB->get_record('jupyter', array('id' => $cm->instance), '*', MUST_EXIST);
        $modulecontext = \context_module::instance($cm->id);
        $jupyterhuburl = get_config('mod_jupyter', 'jupyterhub_url');
        error_handler::show_error_message();

        // Get all notifications.
        $notficationstack = \core\notification::fetch();
        // Two errors are created since jupyterhub is not running (header and detailed info).
        $this->assertEquals(count($notficationstack), 2);

        // Use reflection to access protected properties for testing purpose only.
        $reflection = new ReflectionClass($notficationstack[0]);
        $propertymessage = $reflection->getProperty('message');
        $propertymessagetype = $reflection->getProperty('messagetype');
        $propertymessage->setAccessible(true);
        $propertymessagetype->setAccessible(true);
        $expected = get_string('errorheading', 'jupyter', ['instancename' => $moduleinstance->name]);
        $this->assertEquals($propertymessage->getValue($notficationstack[0]), $expected);
        $this->assertEquals($propertymessagetype->getValue($notficationstack[0]), 'error');

        $reflection = new ReflectionClass($notficationstack[1]);
        $propertymessage = $reflection->getProperty('message');
        $propertymessagetype = $reflection->getProperty('messagetype');
        $propertymessage->setAccessible(true);
        $propertymessagetype->setAccessible(true);
        $expected = get_string('adminsettingserror', 'jupyter', ['url' => $jupyterhuburl]);
        $this->assertEquals($propertymessage->getValue($notficationstack[1]), $expected);
        $this->assertEquals($propertymessagetype->getValue($notficationstack[1]), 'error');
    }
    /**
     * Test if error heading is created if user is no admin.
     * @covers \error_handler
     * @return void
     */
    public function test_error_is_created_noadmin() {
        global $OUTPUT, $CFG, $DB, $SITE, $moduleinstance, $modulecontext;
        $this->resetAfterTest();
        $user = $this->getDataGenerator()->create_user();
        $this->setUser($user);
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_jupyter');
        $jupyter = $generator->create_instance(array('course' => $SITE->id));
        $cm = get_coursemodule_from_instance('jupyter', $jupyter->id);
        $moduleinstance = $DB->get_record('jupyter', array('id' => $cm->instance), '*', MUST_EXIST);
        $modulecontext = \context_module::instance($cm->id);
        $jupyterhuburl = get_config('mod_jupyter', 'jupyterhub_url');
        error_handler::show_error_message();

        // Get all notifications.
        $notficationstack = \core\notification::fetch();
        // Only one error is created since jupyterhub is not running (only header).
        $this->assertEquals(count($notficationstack), 1);

        // Use reflection to access protected properties for testing purpose only.
        $reflection = new ReflectionClass($notficationstack[0]);
        $propertymessage = $reflection->getProperty('message');
        $propertymessagetype = $reflection->getProperty('messagetype');
        $propertymessage->setAccessible(true);
        $propertymessagetype->setAccessible(true);
        $expected = get_string('errorheading', 'jupyter', ['instancename' => $moduleinstance->name]);
        $this->assertEquals($propertymessage->getValue($notficationstack[0]), $expected);
        $this->assertEquals($propertymessagetype->getValue($notficationstack[0]), 'error');
    }
}
