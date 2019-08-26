#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
	CREATE USER thiago WITH PASSWORD 'root';
	CREATE DATABASE wiser_med;
	GRANT ALL PRIVILEGES ON DATABASE wiser_med TO thiago;
EOSQL