# Jupyterhub Docker
This folder contains a simple jupyterhub docker deployment, that uses a postgres database and spawns notebooks as docker containers.

## Architecture

This setup was derived from these two guides: [opendreamkit.org/jupyterhub_docker](https://opendreamkit.org/2018/10/17/jupyterhub-docker/), [github.com/jupyterhub/jupyterhub-deploy-docker](https://github.com/jupyterhub/)  

This is a quick explanation on how the deployment is built:  
- create new directory
- create a docker-compose.yml file with jupyterhub and a postgres database as services
  - add port forwarding for the ui and the api
  - add volumes
  - add environent variables
- create a .env file with the given content
- create jupyterhub directory
  - create a jupyterhub_config.py with the jupyterhub configuration
  - create a Dockerfile in a new directory
    - point to jupyterhub docker image  
    - copy jupyterhub_config.py into the image
    - install required dependencies
  
# Setup
 If you are on linux or macos there is also a [makefile](Makefile) you can use for the setup process.  
 (This makefiles deletes already exhisting jupyterhub volumes and creates new ones, so only use for testing or modify the makefile)  

## Create volumes and network:  
`docker volume create --name=jupyterhub-data`  
`docker volume create --name=jupyterhub-db-data`  
`docker network create jupyterhub-network`  

## Build & Run:  
Run `docker-compose build && docker-compose up` (make sure you are in the jupyterhub_docker folder)

## Testing
The jupyterhub uses a json web token [authenticator](https://github.com/izihawa/jwtauthenticator_v2).  
- To test this setup you can create a json web token on [this](https://jwt.io/#debugger-io) site. 
In the 'verify signature' field the secret can stay 'your-256-bit-secret' as it is (the secret should matche the one in the [jupyterhub_config](jupyterhub/jupyterhub_config.py) then).
'secret base64 encoded' should NOT be checked. 
- Use [this](https://chrome.google.com/webstore/detail/modheader/idgpnmonknjnojddfkpgkljpfnnfcklj?hl=en) chrome addon or something simmilar to set a request header called Authorization with the encoded token from the link above.
- Visit [127.0.0.1:8000](127.0.0.1:8000). If you set the token correctly you should be redirected to a jupyterhub notebook with the username you specified.
