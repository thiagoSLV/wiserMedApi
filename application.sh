#!/bin/bash

set -e

sleep 30
php artisan migrate:refresh --seed

bash