#!/usr/bin/env sh

rm site/databases/database.sqlite 2>/dev/null
sqlite3 site/databases/database.sqlite < db/dump.sql
