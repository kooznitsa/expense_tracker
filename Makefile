include .env

DOCKER_COMPOSE := docker compose
DOCKER_EXEC := docker exec

# -------------- DOCKER --------------
# Runs containers: mysql8, php83
.PHONY: run
run:
	$(DOCKER_COMPOSE) up -d --build

# Runs containers: mysql8, php83, phpmyadmin, redis
.PHONY: fullrun
fullrun:
	$(DOCKER_COMPOSE) --profile all up -d --build

# Removes containers: mysql8, php83
.PHONY: stop
stop:
	$(DOCKER_COMPOSE) down

# Removes containers: mysql8, php83, phpmyadmin, redis
.PHONY: fullstop
fullstop:
	$(DOCKER_COMPOSE) --profile all down

# -------------- COMPOSER --------------
# Initializes composer
.PHONY: composerinit
composerinit:
	$(DOCKER_EXEC) lamp-php83 composer init

# Creates vendor directory
.PHONY: composerdump
composerdump:
	$(DOCKER_EXEC) lamp-php83 composer dump-autoload

# Validates composer
.PHONY: composervalidate
composervalidate:
	$(DOCKER_EXEC) lamp-php83 composer validate
