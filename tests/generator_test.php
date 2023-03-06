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
 * PHPUnit data generator testcase.
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class generator_test extends \advanced_testcase {
    /**
     * Tests if plugin instance is created succesfully and can be addded to a course.
     * @covers \lib.php
     * @return void
     */
    public function test_create_instance() {
        global $DB;
        $this->resetAfterTest();
        $this->setAdminUser();

        $course = $this->getDataGenerator()->create_course();

        $this->assertFalse($DB->record_exists('jupyter', array('course' => $course->id)));
        $jupyter = $this->getDataGenerator()->create_module('jupyter', array('course' => $course));
        $records = $DB->get_records('jupyter', array('course' => $course->id), 'id');
        $this->assertEquals(1, count($records));
        $this->assertTrue(array_key_exists($jupyter->id, $records));

        $params = array('course' => $course->id, 'name' => 'Another jupyter');
        $jupyter = $this->getDataGenerator()->create_module('jupyter', $params);
        $records = $DB->get_records('jupyter', array('course' => $course->id), 'id');
        $this->assertEquals(2, count($records));
        $this->assertEquals('Another jupyter', $records[$jupyter->id]->name);
    }
}
