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

/**
 *
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_jupyter;

class git_generator_test extends \advanced_testcase {
    public function test_gen_gitfile_standard() {
        $gitfilelink = \mod_jupyter\git_generator::gen_gitfilelink("https://github.com/username/reponame", "notebook.ipynb", "branch");
        $this->assertEquals($gitfilelink, "https://github.com/username/reponame/blob/branch/notebook.ipynb");
    }
    public function test_gen_gitfile_empty() {
        $gitfilelink = \mod_jupyter\git_generator::gen_gitfilelink("", "", "");
        $this->assertEquals($gitfilelink, "/blob//");
    }
    public function test_gen_gitpath_standard() {
        $gitpath = \mod_jupyter\git_generator::gen_gitpath("https://github.com/username/reponame", "notebook.ipynb", "branch");
        $this->assertEquals($gitpath, '/hub/user-redirect/git-pull?repo=https%3A%2F%2Fgithub.com%2Fusername%2Freponame&urlpath=lab%2Ftree%2Freponame%2Fnotebook.ipynb&branch=branch');
    }
}
