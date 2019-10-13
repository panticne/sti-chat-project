#!/usr/bin/env sh

rm database.sqlite 2>/dev/null
sqlite3 database.sqlite < dump.sql
