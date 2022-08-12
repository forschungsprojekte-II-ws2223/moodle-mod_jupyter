# Jupyter Moodle Plugin #

This directory includes only the plugin code.

## Installing with install.sh script ##

If you are using the [moodle-docker setup](../moodle_docker/README.md) you can use the [installer script](install.sh)
to install/update the plugin into the running container.

1. execute the script:
```shell
./install.sh
```  
(if you are on Windows you can just execute the commands in the script manually (or write a Windows version of the script))
2. log into your moodle site as admin and go to _Site administration >
Notifications_ to complete the installation.

### Updating
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


## Installing new dependencies ##

To get started, you first have to install Composer locally (see https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos
https://getcomposer.org/doc/00-intro.md#installation-windows).

New dependencies can be added in the `_composer.json_` file via the `__require__` key (package names are mapped to version constraints; see _composer.json_ for an example). Afterwards, you have to run
```shell
$ composer update
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

## Authenticate Description ##

After you install the plugin, add it to your course and click on the activity.
The site encodes the unique username of moodle of the currently logged in user to a valid jwt token (it looks like this `jwt.io`).
It has an expiration time of 15 seconds, after that the token is not valid anymore and can't be used.
Then this token is sent to jupyterhub and decoded.
In an iframe the jupyterhub will load the users personal jupyter notebook.
