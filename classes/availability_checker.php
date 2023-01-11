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
require($CFG->dirroot . '/mod/jupyter/vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Exception\MalformedUriException;

class availability_checker {
    /**
     * Send HTTP request to URL and return response status code
     * @param string $url The URL to check for availability.
     * @return array Returns HTTP status code of the request and response header string
     */
    public static function check_url(string $url): array {
        $client = new Client();
        try {
            $res = $client->get($url);
        } catch (RequestException $e) {
            $res = $e->getResponse();
        } catch (ConnectException | MalformedUriException $e) {
            return [0, ""];
        }

        return [
            $res->getStatusCode(),
            $res->getHeaderLine("x-jupyterhub-version")
        ];
    }

    /**
     * Checks if JupyterHub is reachable
     * @param string $url
     * @return bool
     */
    public static function check_jupyter(string $url): bool {
        self::check_url($url);

        if ($res[0] !== 401 && strpos($url, "127.0.0.1") !== false) {
            $res = self::check_url(str_replace("127.0.0.1", "host.docker.internal", $url));
        }

        // Check if respose code matches and "x-jupyterhub-version" header is set in response header.
        // Response code should be 401 because we didnt pass an auth token.
        return $res[0] === 401 && $res[1] != "";
    }
}
