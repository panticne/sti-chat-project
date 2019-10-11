#!/usr/bin/env sh

rm database.sqlite
sqlite3 database.sqlite < dump.sql
