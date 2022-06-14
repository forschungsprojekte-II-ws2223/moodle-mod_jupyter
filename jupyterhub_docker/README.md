# Jupyterhub Docker
This folder contains a simple jupyterhub docker deployment, that uses a postgres database and spawns notebooks as docker containers.
## Setup
To setup a Jupyterhub, follow the Instruction on [this page](https://opendreamkit.org/2018/10/17/jupyterhub-docker/) without doing the reverse proxy part

- create new directory
- create a docker-compose.yml file with jupyterhub as a service
  - add a port
- create a .env file with the given content
- create a Dockerfile in a new direction
- create a jupyterhub_config.py

Create volumes and network:  
`docker volume create --name=jupyterhub-data`  
`docker volume create --name=jupyterhub-db-data`  
`docker network create jupyterhub-network`  

##Build & Run:  
- Run `docker-compose build && docker-compose up` (make sure you are in the jupyterhub_docker folder)
- Open [localhost:8000](https://localhost:8000) in the browser and enter random credentials to login

## Testing
The UI runs on [127.0.0.1:8080](127.0.0.1:8080).  
For now, a dummy authenticator is enabled, so you can just login with a random user & pw combination.
