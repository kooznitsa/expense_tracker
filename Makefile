include .env

DOCKER_COMPOSE := docker compose
DOCKER_EXEC := docker exec
BACKEND_CONTAINER := lamp-php83


# -------------- DOCKER --------------
# Runs containers
.PHONY: run
run:
	$(DOCKER_COMPOSE) up -d --build

# Removes containers
.PHONY: stop
stop:
	$(DOCKER_COMPOSE) down


# -------------- COMPOSER --------------
# Initializes composer
.PHONY: init
init:
	$(DOCKER_EXEC) $(BACKEND_CONTAINER) composer init

# Performs autoloading
.PHONY: dump
dump:
	$(DOCKER_EXEC) $(BACKEND_CONTAINER) composer dump-autoload

# Installs dependencies
.PHONY: install
install:
	$(DOCKER_EXEC) $(BACKEND_CONTAINER) composer install

# Validates composer
.PHONY: validate
validate:
	$(DOCKER_EXEC) $(BACKEND_CONTAINER) composer validate


# -------------- DATABASE --------------
# Populates database
.PHONY: database
database:
	$(DOCKER_EXEC) $(BACKEND_CONTAINER) composer run-script database
