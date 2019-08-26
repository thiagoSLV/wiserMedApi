#!/bin/bash

set -e

php artisan migrate:refresh --seed

bash