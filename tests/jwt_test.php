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
require(dirname(__DIR__, 1). '/vendor/autoload.php');

use Firebase\JWT\JWT;
namespace Firebase\JWT;
use stdClass;
use ArrayObject;
/**
 * @package     mod_jupyter
 * @copyright   KIB3 StuPro SS2022 Development Team of the University of Stuttgart
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class jwt_test extends \advanced_testcase {
    /**
     * @coversNothing
     */
    public function test_simple_encode() {
        $this->resetAfterTest();
        global $USER;
        $user = $this->getDataGenerator()->create_user(array('email' => 'user@example.com', 'username' => 'user'));
        $this->setUser($user);
        $uniqueid = mb_strtolower($USER->username, "UTF-8");
        $jwt = JWT::encode([
            "name" => $uniqueid,
            "iat" => time(),
            "exp" => time() + 15
        ], get_config('mod_jupyter', 'jupytersecret'), 'HS256');
        $decoded = JWT::decode($jwt, new Key('your-256-bit-secret', 'HS256'));
        $this->assertSame($decoded->name, $uniqueid);
    }
}
