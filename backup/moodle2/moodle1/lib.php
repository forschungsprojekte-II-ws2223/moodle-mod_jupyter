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
 * Provides support for the conversion of moodle1 backup to the moodle2 format
 *
 * @package    mod_jupyter
 * @copyright  2011 Andrew Davis <andrew@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Folder conversion handler. This resource handler is called by moodle1_mod_resource_handler
 */
class moodle1_mod_jupyter_handler extends moodle1_resource_successor_handler {

    /** @var moodle1_file_manager instance */
    protected $fileman = null;

    /**
     * Converts /MOODLE_BACKUP/COURSE/MODULES/MOD/RESOURCE data
     * Called by moodle1_mod_resource_handler::process_resource()
     */
    public function process_legacy_resource(array $data, array $raw = null) {
        // get the course module id and context id
        $instanceid = $data['id'];
        $currentcminfo = $this->get_cminfo($instanceid);
        $moduleid = $currentcminfo['id'];
        $contextid = $this->converter->get_contextid(CONTEXT_MODULE, $moduleid);

        // convert legacy data into the new jupyter record
        $jupyter = array();
        $jupyter['id'] = $data['id'];
        $jupyter['name'] = $data['name'];
        $jupyter['timemodified'] = $data['timemodified'];
        $jupyter['intro']= $data['intro'];
        $jupyter['introformat'] = $data['introformat'];
        $jupyter['revision'] = 1;
        $jupyter['repourl'] = $data['repourl'];
        $jupyter['branch'] = $data['branch'];
        $jupyter['file'] = $data['file'];

        // get a fresh new file manager for this instance
        $this->fileman = $this->converter->get_file_manager($contextid, 'mod_jupyter');

        // migrate the files embedded into the intro field
        $this->fileman->filearea = 'intro';
        $this->fileman->itemid   = 0;
        $jupyter['intro'] = moodle1_converter::migrate_referenced_files($jupyter['intro'], $this->fileman);

        // migrate the jupyter files
        $this->fileman->filearea = 'content';
        $this->fileman->itemid   = 0;
        if (empty($data['reference'])) {
            $this->fileman->migrate_directory('course_files');
        } else {
            $this->fileman->migrate_directory('course_files/'.$data['reference']);
        }

        // write jupyter.xml
        $this->open_xml_writer("activities/jupyter_{$moduleid}/jupyter.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $moduleid,
            'modulename' => 'jupyter', 'contextid' => $contextid));
        $this->write_xml('jupyter', $jupyter, array('/jupyter/id'));
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        // write inforef.xml
        $this->open_xml_writer("activities/jupyter_{$moduleid}/inforef.xml");
        $this->xmlwriter->begin_tag('inforef');
        $this->xmlwriter->begin_tag('fileref');
        foreach ($this->fileman->get_fileids() as $fileid) {
            $this->write_xml('file', array('id' => $fileid));
        }
        $this->xmlwriter->end_tag('fileref');
        $this->xmlwriter->end_tag('inforef');
        $this->close_xml_writer();
    }
}
