# Moodle Docker Container
This docker-compose file creates a moodle-docker container with a mariadb database.  

## Setup:
To start the container run (make sure you are in the moodle_docker folder):  
```shell
docker-compose up -d
```
The web ui runs on [127.0.0.1:80](http://127.0.0.1:80). Initial startup of the moodle-container takes a bit of time.  
The database can be accessed on port `3306` and with the user `bn_moodle` without a password.
## Testing:
The default username is `user` and the default password is `bitnami`.
