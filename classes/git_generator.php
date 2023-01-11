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
 * Provides assertment of functions used in the plugin
 *
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_jupyter;

defined('MOODLE_INTERNAL') || die();

class git_generator {
    /**
     * Creates nbgitpuller part of the link to the JupyterHub.
     * @param string $repo Repository to use
     * @param string $file File to use
     * @param string $branch Branch to use
     * @return string The formatted path and query parameters for nbgitpuller
     */
    public static function gen_gitpath($repo, $file, $branch): string {

        if (preg_match("/\/$/", "$repo")) {
            $repo = substr($repo, 0, strlen($repo) - 1);
        }

        return '/hub/user-redirect/git-pull?repo=' .
            urlencode($repo) .
            '&urlpath=lab%2Ftree%2F' .
            urlencode(substr(strrchr($repo, "/"), 1)) .
            '%2F' .
            $file .
            '&branch=' .
            $branch;
    }

     /**
    * Generates link to file in git repository.
    * @param string $repo Repository to use
    * @param string $file File to use
    * @param string $branch Branch to use
    * @return string example: https://github.com/username/reponame/blob/branch/notebook.ipynb
    */
    public static function gen_gitfilelink($repo, $file, $branch): string {

        if (preg_match("/\/$/", "$repo")) {
            $repo = substr($repo, 0, strlen($repo) - 1);
        }

        return $repo . "/blob/" . $branch . "/" . $file;
    }
}
