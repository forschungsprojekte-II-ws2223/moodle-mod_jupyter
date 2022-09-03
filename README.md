# KIB3 StuPro SS 22

This Moodle plugin integrates Jupyter Notebooks to offer a virtual programming environment.

This plugin connects to a JupyterHub server and authenticates the Moodle users on the JupyterHub Server. That way they
can access a Jupyter notebook from within Moodle. Further development includes the options to submit solved
notebooks and to distribute notebooks by the teacher top the students.



# How to use this repository #

There's an .editorconfig in this repo, please use it while working on it
[VS Code Extension](vscode://extension/EditorConfig.EditorConfig)

## Environment Setup

There are two directories including some docker-based setups to start a [Moodle](./moodle_docker/README.md) and a 
 [JupyterHub Instance](./jupyterhub_docker/README.md). If you got both of them running, you can install the Moodle plugin 
as described in the dedicated [README.md](./jupyter/README.md)


## Access plugin UI in course ##

1. Perform a composer update `composer update` to update dependencies (you need to have composer installed: https://getcomposer.org/download/)
2. Make sure you have a running JupyterHub Moodle environment and installed the Jupyter plugin as described above
3. Click on one of your courses (if there is non you have to create a course first)
4. Make sure editing is turned on, at the top right
5. Now you can click on `Add an activity or resource` below on the right
6. Choose the `JupyterHub` activity plugin
7. Assign a name, the rest of the settings can be ignored
8. Click on `Save and display`
9. You should see your personal JupyterLab environment based on your Moodle username and id inside an iFrame

## Authentication description ##

For the authentication description visit the [README.md](./jupyter/README.md) file and scroll to the last paragraph "Authentication description".

## License ##

**Kuenstliche Intelligenz in die Berufliche Bildung Bringen (KIB3)**
**2022 summer semester student project of University of Stuttgart**

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see [GNU license](https://www.gnu.org/licenses).

## Additional resources
* [Moodle official development main page](https://docs.moodle.org/dev/Main_Page)
* [Moodle official output api page](https://docs.moodle.org/dev/Output_API)
* [Moodle official javascript page](https://docs.moodle.org/dev/Javascript_Modules)
* [Moodle official development activity modules page](https://docs.moodle.org/dev/Activity_modules)
* [Moodle programming course](https://www.youtube.com/playlist?list=PLgfLVzXXIo5q10qVXDVyD-JZVyZL9pCq0)

## Development Team
* Buchholz, Max
* Günther, Ralph
* Klaß, Robin
* König, Solveigh
* Marinic, Noah
* Schüle, Maximilian
* Stoll, Timo
* Weber, Raphael
* Wohlfart, Phillip
* Zhang, Yichi
* Zoller, Nick

developed this plugin in the context of the Student Project of University of Stuttgart in the Summer Semester 2022
