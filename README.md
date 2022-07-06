# KIB3 StuPro SS 22

# While working #

There's an .editorconfig in this repo, please use it while working on it

# Jupyter Hub #

TODO Describe the plugin shortly here.

TODO Provide more detailed description here.

## Installing via uploaded ZIP file ##

1. Pack the directory containing the plugin code (/jupyter) into a .zip (If you download the directory from GitLab, the plugin folder is in an additional folder and will cause problems if you attempt to install directly from that archive! The most upper folder in the archive should be the jupyter/plugin folder!)

2. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
3. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type (activity module) is not automatically detected, which shouldn't be the case usually.
4. Check the plugin validation report that shows up right after for the validation result (ideally _Validation successful, installation can continue_) and finish the installation.

## Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/mod/jupyter

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## Authentication ##

navigate to /jupyter/auth/README.md for instruction how to authenticate moodle with jupyterhub

## Access UI Prototype ##

1. make sure you have an a running moodle environment and installed the jupyter plugin as described above
2. open `http://127.0.0.1/mod/jupyter/ui/manage.php` in your browser

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

### Global configuration
* The global configuration of the block is available at : *http://localhost/admin/settings.php?section=blocksettinghelloworld*

## The Architecture of *hello world*

## Contributing

## Sponsors

## Resources
* [Moodle official development main page](https://docs.moodle.org/dev/Main_Page)
* [Moodle official output api page](https://docs.moodle.org/dev/Output_API)
* [Moodle official javascript page](https://docs.moodle.org/dev/Javascript_Modules)
* [Moodle official development block page](https://docs.moodle.org/dev/Blocks)
* [Moodle programming course](https://www.youtube.com/playlist?list=PLgfLVzXXIo5q10qVXDVyD-JZVyZL9pCq0)
