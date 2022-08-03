# Jupyterhub Docker
This folder contains a simple jupyterhub docker deployment, that uses a postgres database and spawns notebooks as docker containers.

# Setup

First make sure you are in the jupyterhub_docker folder.
If you are on linux or macOS there is also a [makefile](Makefile) you can use for the setup process.
(This makefiles deletes already existing jupyterhub volumes and creates new ones, so only use for testing or modify the makefile)  
If running the makefile was successful the following steps aren't necessary anymore.

## Create volumes and network:  
Run:
```shell
docker volume create --name=jupyterhub-data
docker volume create --name=jupyterhub-db-data
docker network create jupyterhub-network
``` 

## Build & Run:  
Run:
```shell
docker-compose build
docker-compose up
``` 
(make sure you are in the jupyterhub_docker folder)

## Testing
The jupyterhub uses a json web token [authenticator](https://github.com/izihawa/jwtauthenticator_v2).  
- To test this setup you can create a json web token on [this](https://jwt.io/#debugger-io) site. 
In the 'verify signature' field the secret can stay 'your-256-bit-secret' as it is (the secret should match the one in the [environment file](.env) then).
'secret base64 encoded' should NOT be checked. 
- You can now add the token as a query parameter to the address that your jupyterhub is running on.  
For example: http://127.0.0.1:8000/?auth_token=**your token here**

## Manage dependencies
### Update docker dependencies
- Stop the running containers
- Make the version changes in the [docker-compose](docker-compose.yml) file you want to make.
- Run `docker-compose pull` then wait for the download of the new dependencies.
- Run `docker-compose up -d` and wait for the containers to be recreated.
- Then the containers can be used again.

### Manage python dependencies
The libraries are managed through the [requirements.txt](https://pip.pypa.io/en/stable/reference/requirements-file-format/). This way one can specify certain versions, upgrade versions or add additional libraries.

## Architecture

This setup was derived from these two guides: [OpenDreamKit](https://opendreamkit.org/2018/10/17/jupyterhub-docker/), [GitHub repo](https://github.com/jupyterhub/)

This is a quick explanation on how the deployment is built:
- create new directory
- create a docker-compose.yml file with jupyterhub and a postgres database as services
    - add port forwarding for the ui and the api
    - add volumes
    - add environment variables
- create a .env file with the given content
- create JupyterLab directory
    - create jupyter_notebook_config.py with the JupyterLab configuration
    - create a Dockerfile
        - point to JupyterLab docker image
        - copy jupyter_notebook_config.py into the image
        - install required dependencies
- create jupyterhub directory
    - create a jupyterhub_config.py with the jupyterhub configuration
    - create a Dockerfile
        - point to jupyterhub docker image
        - copy jupyterhub_config.py into the image
        - install required dependencies
