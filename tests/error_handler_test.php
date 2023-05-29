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

use ReflectionClass;

/**
 * Test cases for error message creation in view.php if settings are not correct.
 *
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
     * Test if jupyter connect error is created with additional information when user is admin.
     * @covers \error_handler
     * @return void
     */
    public function test_jupyter_connect_err() {
        global $modulecontext;
        $this->setup_test(true);
        // Create error notification.
        error_handler::jupyter_connect_err('errortext', $modulecontext);

        // Get all notifications.
        $notficationstack = \core\notification::fetch();
        // One notification should be on the stack.
        $this->assertEquals(count($notficationstack), 1);

        // Use reflection to access protected properties for testing purpose only.
        $reflection = new ReflectionClass($notficationstack[0]);
        $propertymessage = $reflection->getProperty('message');
        $propertymessagetype = $reflection->getProperty('messagetype');
        $propertymessage->setAccessible(true);
        $propertymessagetype->setAccessible(true);
        // Additional information in error message expected.
        $expected = get_string('jupyter_connect_err_admin', 'jupyter', [
            'url' => get_config('mod_jupyter', 'jupyterhub_url'),
            'msg' => 'errortext'
        ]);
        // Check if provided type and message are correct.
        $this->assertEquals($propertymessage->getValue($notficationstack[0]), $expected);
        $this->assertEquals($propertymessagetype->getValue($notficationstack[0]), 'error');
    }
    /**
     * Test if jupyter connect error is created without additional information when user is no admin.
     * @covers \error_handler
     * @return void
     */
    public function test_jupyter_connect_err_no_admin() {
        global $modulecontext;
        $this->setup_test(false);
        // Create error notification.
        error_handler::jupyter_connect_err('errortext', $modulecontext);

        // Get all notifications.
        $notficationstack = \core\notification::fetch();
        // One notification should be on the stack.
        $this->assertEquals(count($notficationstack), 1);

        // Use reflection to access protected properties for testing purpose only.
        $reflection = new ReflectionClass($notficationstack[0]);
        $propertymessage = $reflection->getProperty('message');
        $propertymessagetype = $reflection->getProperty('messagetype');
        $propertymessage->setAccessible(true);
        $propertymessagetype->setAccessible(true);
        // Simple error message expected.
        $expected = get_string('jupyter_connect_err', 'jupyter');
        // Check if provided type and message are correct.
        $this->assertEquals($propertymessage->getValue($notficationstack[0]), $expected);
        $this->assertEquals($propertymessagetype->getValue($notficationstack[0]), 'error');
    }

    /**
     * Test if jupyter connect error is created with additional information when user is admin.
     * @covers \error_handler
     * @return void
     */
    public function test_jupyter_resp_err() {
        global $modulecontext;
        $this->setup_test(true);
        // Create error notification.
        error_handler::jupyter_resp_err('errortext', $modulecontext);

        // Get all notifications.
        $notficationstack = \core\notification::fetch();
        // One notification should be on the stack.
        $this->assertEquals(count($notficationstack), 1);

        // Use reflection to access protected properties for testing purpose only.
        $reflection = new ReflectionClass($notficationstack[0]);
        $propertymessage = $reflection->getProperty('message');
        $propertymessagetype = $reflection->getProperty('messagetype');
        $propertymessage->setAccessible(true);
        $propertymessagetype->setAccessible(true);
        // Additional information in error message expected.
        $expected = get_string('jupyter_resp_err_admin', 'jupyter', [
            'url' => get_config('mod_jupyter', 'jupyterhub_url'),
            'msg' => 'errortext'
        ]);
        // Check if provided type and message are correct.
        $this->assertEquals($propertymessage->getValue($notficationstack[0]), $expected);
        $this->assertEquals($propertymessagetype->getValue($notficationstack[0]), 'error');
    }
    /**
     * Test if jupyter connect error is created without additional information when user is no admin.
     * @covers \error_handler
     * @return void
     */
    public function test_jupyter_resp_err_no_admin() {
        global $modulecontext;
        $this->setup_test(false);
        // Create error notification.
        error_handler::jupyter_resp_err('errortext', $modulecontext);

        // Get all notifications.
        $notficationstack = \core\notification::fetch();
        // One notification should be on the stack.
        $this->assertEquals(count($notficationstack), 1);

        // Use reflection to access protected properties for testing purpose only.
        $reflection = new ReflectionClass($notficationstack[0]);
        $propertymessage = $reflection->getProperty('message');
        $propertymessagetype = $reflection->getProperty('messagetype');
        $propertymessage->setAccessible(true);
        $propertymessagetype->setAccessible(true);
        // Simple error message expected.
        $expected = get_string('jupyter_resp_err', 'jupyter');
        // Check if provided type and message are correct.
        $this->assertEquals($propertymessage->getValue($notficationstack[0]), $expected);
        $this->assertEquals($propertymessagetype->getValue($notficationstack[0]), 'error');
    }


    /**
     * Test if gradeservice connect error is created with additional information when user is admin.
     * @covers \error_handler
     * @return void
     */
    public function test_gradeservice_connect_err() {
        global $modulecontext;
        $this->setup_test(true);
        // Create error notification.
        error_handler::gradeservice_connect_err('errortext', $modulecontext);

        // Get all notifications.
        $notficationstack = \core\notification::fetch();
        // One notification should be on the stack.
        $this->assertEquals(count($notficationstack), 1);

        // Use reflection to access protected properties for testing purpose only.
        $reflection = new ReflectionClass($notficationstack[0]);
        $propertymessage = $reflection->getProperty('message');
        $propertymessagetype = $reflection->getProperty('messagetype');
        $propertymessage->setAccessible(true);
        $propertymessagetype->setAccessible(true);
        // Additional information in error message expected.
        $expected = get_string('gradeservice_connect_err_admin', 'jupyter', [
            'url' => get_config('mod_jupyter', 'jupyterhub_url'),
            'msg' => 'errortext'
        ]);
        // Check if provided type and message are correct.
        $this->assertEquals($propertymessage->getValue($notficationstack[0]), $expected);
        $this->assertEquals($propertymessagetype->getValue($notficationstack[0]), 'error');
    }
    /**
     * Test if gradeservice connect error is created without additional information when user is no admin.
     * @covers \error_handler
     * @return void
     */
    public function test_gradeservice_connect_err_no_admin() {
        global $modulecontext;
        $this->setup_test(false);
        // Create error notification.
        error_handler::gradeservice_connect_err('errortext', $modulecontext);

        // Get all notifications.
        $notficationstack = \core\notification::fetch();
        // One notification should be on the stack.
        $this->assertEquals(count($notficationstack), 1);

        // Use reflection to access protected properties for testing purpose only.
        $reflection = new ReflectionClass($notficationstack[0]);
        $propertymessage = $reflection->getProperty('message');
        $propertymessagetype = $reflection->getProperty('messagetype');
        $propertymessage->setAccessible(true);
        $propertymessagetype->setAccessible(true);
        // Simple error message expected.
        $expected = get_string('gradeservice_connect_err', 'jupyter');
        // Check if provided type and message are correct.
        $this->assertEquals($propertymessage->getValue($notficationstack[0]), $expected);
        $this->assertEquals($propertymessagetype->getValue($notficationstack[0]), 'error');
    }

    /**
     * Test if gradeservice connect error is created with additional information when user is admin.
     * @covers \error_handler
     * @return void
     */
    public function test_gradeservice_resp_err() {
        global $modulecontext;
        $this->setup_test(true);
        // Create error notification.
        error_handler::gradeservice_resp_err('errortext', $modulecontext);

        // Get all notifications.
        $notficationstack = \core\notification::fetch();
        // One notification should be on the stack.
        $this->assertEquals(count($notficationstack), 1);

        // Use reflection to access protected properties for testing purpose only.
        $reflection = new ReflectionClass($notficationstack[0]);
        $propertymessage = $reflection->getProperty('message');
        $propertymessagetype = $reflection->getProperty('messagetype');
        $propertymessage->setAccessible(true);
        $propertymessagetype->setAccessible(true);
        // Additional information in error message expected.
        $expected = get_string('gradeservice_resp_err_admin', 'jupyter', [
            'url' => get_config('mod_jupyter', 'jupyterhub_url'),
            'msg' => 'errortext'
        ]);
        // Check if provided type and message are correct.
        $this->assertEquals($propertymessage->getValue($notficationstack[0]), $expected);
        $this->assertEquals($propertymessagetype->getValue($notficationstack[0]), 'error');
    }
    /**
     * Test if gradeservice response error is created without additional information when user is no admin.
     * @covers \error_handler
     * @return void
     */
    public function test_gradeservice_resp_err_no_admin() {
        global $modulecontext;
        $this->setup_test(false);
        // Create error notification.
        error_handler::gradeservice_resp_err('errortext', $modulecontext);

        // Get all notifications.
        $notficationstack = \core\notification::fetch();
        // One notification should be on the stack.
        $this->assertEquals(count($notficationstack), 1);

        // Use reflection to access protected properties for testing purpose only.
        $reflection = new ReflectionClass($notficationstack[0]);
        $propertymessage = $reflection->getProperty('message');
        $propertymessagetype = $reflection->getProperty('messagetype');
        $propertymessage->setAccessible(true);
        $propertymessagetype->setAccessible(true);
        // Simple error message expected.
        $expected = get_string('gradeservice_resp_err', 'jupyter');
        // Check if provided type and message are correct.
        $this->assertEquals($propertymessage->getValue($notficationstack[0]), $expected);
        $this->assertEquals($propertymessagetype->getValue($notficationstack[0]), 'error');
    }

    private function setup_test(bool $admin) {
        global $DB, $SITE, $moduleinstance, $modulecontext;
        $this->resetAfterTest();
        if ($admin) {
            $this->setAdminUser();
        } else {
            $user = $this->getDataGenerator()->create_user();
            $this->setUser($user);
        }
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_jupyter');
        $jupyter = $generator->create_instance(array('course' => $SITE->id));
        $cm = get_coursemodule_from_instance('jupyter', $jupyter->id);
        $moduleinstance = $DB->get_record('jupyter', array('id' => $cm->instance), '*', MUST_EXIST);
        $modulecontext = \context_module::instance($cm->id);
    }
}
