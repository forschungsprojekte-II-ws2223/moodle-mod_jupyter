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
        global $DB, $SITE;
        $this->resetAfterTest();
        $this->setAdminUser();

        // There are 0 jupyter modules initially.
        $this->assertEquals(0, $DB->count_records('jupyter'));

        // Create generator.
        $generator = $this->getDataGenerator()->get_plugin_generator('mod_jupyter');
        // Check if it is a jupyter generator.
        $this->assertInstanceOf('mod_jupyter_generator', $generator);
        // Check if corresponding mod is jupyter.
        $this->assertEquals('jupyter', $generator->get_modulename());

        // Create three instances in the site course.
        $generator->create_instance(array('course' => $SITE->id));
        $generator->create_instance(array('course' => $SITE->id));
        $jupyter = $generator->create_instance(array('course' => $SITE->id));
        $this->assertEquals(3, $DB->count_records('jupyter'));

        // Check if the course-module is correct.
        $cm = get_coursemodule_from_instance('jupyter', $jupyter->id);
        $this->assertEquals($jupyter->id, $cm->instance);
        $this->assertEquals('jupyter', $cm->modname);
        $this->assertEquals($SITE->id, $cm->course);

        // Check if the context is correct.
        $context = \context_module::instance($cm->id);
        $this->assertEquals($jupyter->cmid, $context->instanceid);

        // Check that generated jupyter modules each contain a file.
        $fs = get_file_storage();
        $files = $fs->get_area_files($SITE->id, 'mod_jupyter', 'package', false, '', false);
        $this->assertCount(3, $files);
        $index = 1;
        foreach ($files as $file) {
            $this->assertEquals($file->get_filename(), 'testfile' . $index . '.ipynb');
            $index++;
        }
    }
}
