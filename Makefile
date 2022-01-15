#!/bin/bash

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
SHELL = /bin/sh

OS := $(shell uname)
DOCKER_BE = mars-rover_nginx_1
USER = application

ACTION := $(ACTION '')

args = `arg="$(filter-out $@,$(MAKECMDGOALS))" && echo $${arg:-${1}}`

ifeq ($(OS),Darwin)
	UID = $(shell id -u)
else ifeq ($(OS),Linux)
	UID = $(shell id -u)
else
	UID = 1000
endif

##HELP
.PHONY: help
help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':##'

# 🐳 Docker Compose
.PHONY: build
build: ## Rebuilds all the containers
ifeq ($(OS),Darwin)
	U_ID=${UID} docker-compose -f docker-compose.yml build --compress --parallel
else
	U_ID=${UID} docker-compose -f docker-compose.yml build
endif

.PHONY: up
up: ## Start the containers
	@ U_ID=${UID} docker-compose -f docker-compose.yml up -d --force-recreate

.PHONY: stop
stop: ## Stop the containers
	@ U_ID=${UID} docker-compose -f docker-compose.yml stop

.PHONY: down
down: ## Down the containers
	@ U_ID=${UID} docker-compose -f docker-compose.yml down

.PHONY: build-up
build-up: ## Build && Start the containers
	@ $(MAKE) build && $(MAKE) up

.PHONY: restartsetup
restart: ## Restart the containers
	@ $(MAKE) stop && $(MAKE) up

# 🐘 Backend
prepare: ## Runs commands prepare project
	$(MAKE) composer-install
	$(MAKE) yarn-install

.PHONY: composer
composer: ## Use composer inside docker image
	@ docker exec -it -u ${USER} ${DOCKER_BE} sh -c 'cd /var/www/ && composer $(args)'
.PHONY: composer-install
composer-install: ## Installs composer dependencies
	@ docker exec -it -u ${USER} ${DOCKER_BE} sh -c 'cd /var/www/ && composer install'
.PHONY: composer-update
composer-update: ## Installs composer dependencies
	@ docker exec -it -u ${USER} ${DOCKER_BE} sh -c 'cd /var/www/ && composer update'

.PHONY: migrations
migrations: ## Runs the migrations
	@ U_ID=${UID} docker exec -it --user ${UIDUID} ${DOCKER_BE} sh -c ' /var/www/bin/console doctrine:migrations:migrate -n'

.PHONY: ssh
ssh: ## ssh's into the be container
	@ docker exec -it -u ${USER} ${DOCKER_BE} bash
.PHONY: ssh-root
ssh-root: ## ssh's into the be container with root user
	@ docker exec -it ${DOCKER_BE} ssh

.PHONY: web-logs
web-logs: ## Tails the Symfony dev log
	@ docker exec -it -u ${USER} ${DOCKER_BE} tail -f /var/www/var/log/dev.log

.PHONY: console
console: ## Execute command bin/console with arguments between quotes exec the command;  without arguments exec menu console
	@ U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} sh -c ' /var/www/bin/console $(args)'
.PHONY: clean-cache
clean-cache: ## Clean cache web
	make console  "cache:clear"
 # 📚 deploy
 .PHONY: deploy-staging
deploy-staging: ## Deploy staging
	@ ansible-playbook ./deployment/deploy_staging.yml  -i ./deployment/aws_ec2.yml --ask-vault-pass --user=admin
 # 📚 deploy
 .PHONY: deploy-processes-staging
deploy-prod: ## Deploy production
	@ ansible-playbook ./deployment/deploy.yml  -i ./deployment/aws_ec2.yml --ask-vault-pass --user=admin
 # 📚 deploy
.PHONY: yarn-install
yarn-install: ## Installs yarn dependencies
	@ docker exec -ti -u ${USER} ${DOCKER_BE} sh -c 'cd /var/www/ && yarn install'
.PHONY: yarn-watch
yarn-watch: ## Installs yarn dependencies
	@ docker exec -ti -u ${USER} ${DOCKER_BE} sh -c 'cd /var/www/ && yarn watch'
.PHONY: yarn
yarn: ## yarn
	@ docker exec -ti -u ${USER} ${DOCKER_BE} sh -c 'cd /var/www/ && yarn $(args)'
.PHONY: npm
npm: ## npm
	@ docker exec -ti -u ${USER} ${DOCKER_BE} sh -c 'cd /var/www/ && npm $(args)'
.PHONY: test
test: ## Execute Unit Test
	@ U_ID=${UID} docker exec -ti -u ${USER} ${DOCKER_BE} sh -c '/var/www/vendor/bin/simple-phpunit $(args)'
