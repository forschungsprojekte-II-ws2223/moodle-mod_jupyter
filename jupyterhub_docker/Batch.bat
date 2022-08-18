:: this batch file sets up the jupyterhub-docker

ECHO OFF

:: Create volumes and network:
docker volume create --name=jupyterhub-data 
docker volume create --name=jupyterhub-db-data
docker network create jupyterhub-network

:: Build:
docker-compose build

pause

