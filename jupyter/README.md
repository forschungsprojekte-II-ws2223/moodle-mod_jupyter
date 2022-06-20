# Jupyter Moodle Plugin #

TODO Describe the plugin shortly here.

TODO Provide more detailed description here.

## Installing with install.sh script ##

If you are using the bitnami moodle docker image you can use the [install.sh](install.sh) script to install/update the plugin.

1. execute the script: `./install.sh`  
(if you are on windows you can just execute the commands in the script manually (or write a windows version of the script))
2. log into your moodle site as admin and go to _Site administration >
Notifications_ to complete the installation.

updating:  
To update the plugin, just run `./install.sh` again. After a couple of seconds the updated version should be on your moodle server.
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



