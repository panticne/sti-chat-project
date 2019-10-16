#!/usr/bin/env sh

mkdir site/databases 2>/dev/null
rm site/databases/database.sqlite 2>/dev/null
sqlite3 site/databases/database.sqlite < db/dump.sql
