# Authenticate #

## Description ##

Navigating to the authentication site when entering a name in the url encodes the name into valid jwt token (it looks like this `jwt.io`).
Then this token is sent to jupyterhub and decoded. A session cookie will be sent back so that you can use your personal jupyterlab environment in moodle without authenticating again in jupyterhub.

## Test Environment ##

1. make sure moodle docker container (in moodle_docker folder) and jupyterhub container (in jupyterhub_docker folder) are started
2. install the jupyter plugin in moodle
3. open `http://localhost/mod/jupyter/auth/auth.php`

You should be redirected to jupyterlab but you don't.
After you do this in docker there will be created a notebook.
The docker logs show 302 and 200 http status codes.
In your web ui you encounter the 404 error in the browser console.
In browser network you can see that there is still the `127.0.0.1:80` being used when it should use `127.0.0.1:8000` (jupyterhub port).
Probably an issue with the docker network or moodle somehow doesn't allow it. 

## Instructions ##

# NOTE: this is not working yet because there needs to be resolved an issue with the docker network # 

1. make sure moodle docker container (in moodle_docker folder) and jupyterhub container (in jupyterhub_docker folder) are started
2. install the jupyter plugin in moodle
3. open `http://localhost/mod/jupyter/auth/authenticate.php?name=john` after `name=` you can type in your moodle name
4. you should be redirected to your personal jupyterlab environment

