<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Event observer definitions for the mod_jupyter plugin.
 *
 * @package   mod_jupyter
<<<<<<< HEAD
 * @category  event
 * @copyright 2022 onwards, University of Stuttgart(StuPro 2022)
=======
 * @copyright KIB3 StuPro SS 2022 Uni Stuttgart
>>>>>>> 8a965ee (license comments)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$observers = [
[
'eventname' => '\core\event\course_module_viewed',
'callback'  => '\plugintype_pluginname\event\observer\course_module_created::store',
'priority'  => 1000,
],
];

