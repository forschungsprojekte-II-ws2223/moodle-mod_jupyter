# Jupyter Moodle plugin

This Moodle plugin integrates Jupyter Notebooks to offer a virtual programming environment.

The plugin connects to a JupyterHub server and authenticates the Moodle users on the JupyterHub Server. That way they
can access a Jupyter notebook from within Moodle. Further development includes the options to submit solved
notebooks and to distribute notebooks by the teacher to the students.

## Installation

Clone this repository:

```shell
git clone git@github.com:forschungsprojekte-II-ws2223/moodle-mod_jupyter.git jupyter
```

(The folder name should be jupyter not moodle-mod_jupyter)

Add third-party dependencies with [composer](https://getcomposer.org/download/):

```shell
cd jupyter && composer install
```

### Installing via uploaded ZIP file

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
1. Remove the `.git` folder from the directory (else file upload as zip won't work).
1. Upload the ZIP file (jupyter.zip) with the plugin code.
1. Check the plugin validation report and finish the installation.

### Installing manually

The plugin can also be installed by putting the contents of this directory to

    {your/moodle/dirroot}/mod/jupyter

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## Development Environment Setup

Follow [this](https://github.com/forschungsprojekte-II-ws2223/setup/blob/main/DevEnvSetup.md) guide for setting up the development environment.

There's an .editorconfig in this repo, please use it while working on it.

[EditorConfig VS Code Extension](vscode://extension/EditorConfig.EditorConfig)

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
