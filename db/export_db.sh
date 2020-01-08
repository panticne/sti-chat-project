#!/usr/bin/env sh
# Script d'export de la base de données.

sqlite3 database.sqlite .dump > dump.sql
