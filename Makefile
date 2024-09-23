include .env

DOCKER_COMPOSE := docker compose
DOCKER_EXEC := docker exec

# -------------- DOCKER --------------
.PHONY: run
run: run
	$(DOCKER_COMPOSE) up -d --build

.PHONY: stop
stop:
	$(DOCKER_COMPOSE) down

# -------------- COMPOSER --------------
.PHONY: composerinit
composerinit:
	$(DOCKER_EXEC) lamp-php83 composer init

.PHONY: composerdump
composerdump:
	$(DOCKER_EXEC) lamp-php83 composer dump-autoload

.PHONY: composervalidate
composervalidate:
	$(DOCKER_EXEC) lamp-php83 composer validate
