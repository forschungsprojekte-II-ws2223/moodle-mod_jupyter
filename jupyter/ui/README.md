# Authenticate #

## Description ##
This is only needed for testing and explanation of the authentication. It is already working in the ui `manage.php`.

After you install the plugin, navigating to the ./manage.php site in your browser encodes the id and lastname of the currently logged in user to a valid jwt token (it looks like this `jwt.io`).
It has an expiration time of 15 seconds after that the token is not valid anymore and can't be used.
Then this token is sent to jupyterhub and decoded.
In an iframe the jupyterhub will load the users personal jupyter notebook.

## Instructions ##

0. perform a composer update `composer update` to update dependencies
1. make sure moodle docker container (in moodle_docker folder) and jupyterhub container (in jupyterhub_docker folder) are started
2. install the jupyter plugin in moodle
3. open `http://localhost/mod/jupyter/ui/manage.php`
4. you should see your personal jupyterlab environment based on your moodle lastname and id inside an iframe
