#!/bin/bash

set -e

sleep 10
php artisan migrate:refresh --seed

bash