include .env

all:  network volumes build

network:
	@docker network inspect $(DOCKER_NETWORK_NAME) >/dev/null 2>&1 || docker network create $(DOCKER_NETWORK_NAME)
volumes:
	@docker volume create --name $(DATA_VOLUME_HOST)
	@docker volume create --name $(DB_VOLUME_HOST)

build: network volumes
	docker-compose build
