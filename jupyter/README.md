# Jupyter Hub #

TODO Describe the plugin shortly here.

TODO Provide more detailed description here.

## Installing via uploaded ZIP file ##

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file (only jupyter.zip) with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/mod/jupyter

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## Installing new dependencies ##

To get started, you first have to install Composer locally (see https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos
https://getcomposer.org/doc/00-intro.md#installation-windows).

New dependencies can be added in the _composer.json_ file via the __require__ key (package names are mapped to version constraints; see _composer.json_ for an example). Afterwards, you have to run

    $ composer update

to resolve and install the newly added dependencies.

Alternatively, you can run

    $ composer require [dependency you want to add]

which makes running the update command obsolete.

To automatically load all dependencies when executing a php file, you need to include the line

    require 'vendor/autoload.php';

at the start of your file.

## License ##

2022 Your Name <you@example.com>

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.



