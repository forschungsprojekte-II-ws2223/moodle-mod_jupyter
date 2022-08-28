# KIB3 StuPro SS 22

This Moodle plugins allows integrates Moodle and a Jupyter Notebooks to offer a virtual programming environment.

This plugin connects to a jupyterhub server and authenticates the Moodle users on the jupyterhub-server. That way they
can access a jupyter-notebook from within Moodle. Further development includes the options to submit solved
notebooks and to distribute notebooks by the teacher top the students.



# How to use this repository #

There's an .editorconfig in this repo, please use it while working on it
[VS Code Extension](vscode://extension/EditorConfig.EditorConfig)

## Environment Setup
There are two directories including some docker-based setups to start a [Moodle](./moodle_docker/README.md) and a 
 [JupyterHub-Instance](./jupyterhub_docker/README.md). If you got both of them running, you can install the Moodle-Plugin 
as described in the dedicated [Readme.md](./jupyter/README.md)


## Access Plugin UI in course ##

0. perform a composer update `composer update` to update dependencies (you need to have composer installed: https://getcomposer.org/download/)
1. make sure you have a running JupyterHub moodle environment and installed the jupyter plugin as described above
2. click on one of your courses (if there is non you have to create a course first)
3. make sure editing is turned on, at the top right
4. now you can click on `Add an activity or resource` below on the right
5. choose the `Jupyter Hub` activity plugin
6. assign a name. The rest of the settings can be ignored.
7. click on `Save and display`
8. you should see your personal jupyterlab environment based on your moodle lastname and id inside an iframe

## Authentication Description ##

The site encodes the id and lastname of the currently logged in user to a valid jwt token (it looks like this `jwt.io`).
It has an expiration time of 15 seconds, after that the token is not valid anymore and can't be used.
Then this token is sent to jupyterhub and decoded.
In an iframe the jupyterhub will load the users personal jupyter notebook.

## License ##

**Kuenstliche Intelligenz in die Berufliche Bildung Bringen (KIB3)**
**2022 Summer Semester Student Project of University of Stuttgart**

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see [GNU license](https://www.gnu.org/licenses).

## Additional Resources
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

developed this plugin in the context of the Student Project of University of Stuttgart in the summer semester 2022
