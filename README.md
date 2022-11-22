# Jupyter Moodle plugin

This Moodle plugin integrates Jupyter Notebooks to offer a virtual programming environment.

This plugin connects to a JupyterHub server and authenticates the Moodle users on the JupyterHub Server. That way they
can access a Jupyter notebook from within Moodle. Further development includes the options to submit solved
notebooks and to distribute notebooks by the teacher top the students.

# How to use this repository

There's an .editorconfig in this repo, please use it while working on it.  
[EditorConfig VS Code Extension](vscode://extension/EditorConfig.EditorConfig)

## Development Environment Setup

Follow [this](./setup/DevEnvSetup.md) guide for setting up the development environment.

## Access plugin UI in course

1. Make sure you have a running JupyterHub Moodle environment and installed the Jupyter plugin as described above
2. Click on one of your courses (if there is non you have to create a course first)
3. Make sure editing is turned on, at the top right
4. Now you can click on `Add an activity or resource` below on the right
5. Choose the `JupyterHub` activity plugin
6. Assign a name, the rest of the settings can be ignored
7. Click on `Save and display`
8. You should see your personal JupyterLab environment based on your Moodle username and id inside an iFrame

## Installing via uploaded ZIP file

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file (only jupyter.zip) with the plugin code. If your plugin type is not automatically detected, you have to add
   extra details.
3. Check the plugin validation report and finish the installation.

## Installing manually

The plugin can also be installed by putting the contents of this directory to

    {your/moodle/dirroot}/mod/jupyter

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## Plugin settings

Here the user can enter the general settings required to reach the JupyterHub.
Therefore the user can replace the default value with his own URL/IP.
The input cannot be empty and must be a valid URL or IP.

## Installing new dependencies

Make sure that the composer package manager is installed (see [getcomposer.org]()).

New dependencies can be added in the `composer.json` file via the `require` key (package names are mapped to version constraints; see composer.json for an example). Afterwards, you have to run

```shell
$ composer install
```

to resolve and install the newly added dependencies.

Alternatively, you can run

```shell
$ composer require [dependency you want to add]
```

which makes running the update command obsolete.

To automatically load all dependencies when executing a php file, you need to include the line

```php
require 'vendor/autoload.php';
```

at the start of your file.

## License

**Kuenstliche Intelligenz in die Berufliche Bildung Bringen (KIB3)**
**2022 summer semester student project of University of Stuttgart**

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program. If not, see [GNU license](https://www.gnu.org/licenses).

## Additional resources

- [Moodle official development main page](https://docs.moodle.org/dev/Main_Page)
- [Moodle official output api page](https://docs.moodle.org/dev/Output_API)
- [Moodle official javascript page](https://docs.moodle.org/dev/Javascript_Modules)
- [Moodle official development activity modules page](https://docs.moodle.org/dev/Activity_modules)
- [Moodle programming course](https://www.youtube.com/playlist?list=PLgfLVzXXIo5q10qVXDVyD-JZVyZL9pCq0)

## Development Team

- Buchholz, Max
- Günther, Ralph
- Klaß, Robin
- König, Solveigh
- Marinic, Noah
- Schüle, Maximilian
- Stoll, Timo
- Weber, Raphael
- Wohlfart, Phillip
- Zhang, Yichi
- Zoller, Nick

developed this plugin in the context of the Student Project of University of Stuttgart in the Summer Semester 2022
