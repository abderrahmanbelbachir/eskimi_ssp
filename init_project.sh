#!/bin/sh

printf "composer install ... \n" ;
composer install

printf "Cloning laradock ...\n"
git clone https://github.com/Laradock/laradock.git

printf "go to laradock ...\n"
cd laradock

printf "Rename .env.example to .env ...\n"
cp .env.example .env

printf "launch docker-composer build ... \n" ;
docker-compose build nginx mysql phpmyadmin redis workspace

printf "launch docker-composer up -d ... \n" ;
docker-compose up -d nginx mysql phpmyadmin redis workspace

printf "docker-compose exec workspace bash ... \n" ;
docker-compose exec workspace bash

printf "Generating project key ...\n" ;
php artisan key:generate

printf "Executing migration ...\n" ;
php artisan migrate
