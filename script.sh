#!/bin/bash
composer install
composer dump
php artisan key:generate --force
php artisan passport:install
chmod -R 777 storage/*
