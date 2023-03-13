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

/**
 * Test cases for error creation in view.php
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class error_handler_test extends \advanced_testcase {
    /**
     * Test if error is created
     * @covers \error_handler
     * @return void
     */
    public function test_error_is_created() {
        global $CFG, $DB;
        $this->resetAfterTest();
        $this->setAdminUser();
        $course = $this->getDataGenerator()->create_course();
        $jupyter = $this->getDataGenerator()->create_module('jupyter', array('course' => $course->id));
        $moduleinstance = $jupyter;

        // $modulecontext = \context_module::instance($jupyter->cmid);
        // $cm = get_coursemodule_from_instance('jupyter', $jupyter->id);

        // $info = get_fast_modinfo($jupyter);
        // print_object($jupyter);

        // $j = optional_param('j', 0, PARAM_INT);
        // $moduleinstance = $cm;
        $jupyterhuburl = get_config('mod_jupyter', 'jupyterhub_url');
        error_handler::show_error_message();
        \core\notification::error("test");
        $notficationstack = \core\notification::fetch();
        $this->assertEquals(count($notficationstack), 1);
    }

}
