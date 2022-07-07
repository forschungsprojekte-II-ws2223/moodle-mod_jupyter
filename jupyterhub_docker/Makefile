include .env

.DEFAULT_GOAL=build

before: 
	@docker-compose down
network:
	@docker network inspect $(DOCKER_NETWORK_NAME) >/dev/null 2>&1 || docker network create $(DOCKER_NETWORK_NAME)
volumes:
	@docker volume rm -f $(DATA_VOLUME_HOST)
	@docker volume create --name $(DATA_VOLUME_HOST)
	@docker volume rm -f $(DB_VOLUME_HOST)
	@docker volume create --name $(DB_VOLUME_HOST)

build: network volumes
	docker-compose build
	docker-compose up
