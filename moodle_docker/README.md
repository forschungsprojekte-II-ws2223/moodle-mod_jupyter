# Moodle Docker Container
This docker compose file creates a moodle docker container with a mariadb database.  

## Setup:
To start the container:  
`docker-compose up -d` (make sure you are in the moodle_docker folder)  
The web ui runs on [127.0.0.1:80](127.0.0.1:80). Initial startup of the moodle container takes a bit of time.  
The database can be accessed on port `3306` and can be accessed with the user `bn_moodle` without a password.
## Testing:
The default username is `user` and the default passoword is `bitnami`.