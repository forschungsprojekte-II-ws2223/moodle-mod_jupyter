#!/bin/bash

LINE=$(docker ps | grep bitnami/moodle)
CONTAINER_ID=${LINE::12}

docker exec "$CONTAINER_ID" rm -rf /bitnami/moodle/mod/jupyter
docker cp . "$CONTAINER_ID":/bitnami/moodle/mod/jupyter
