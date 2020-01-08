#!/usr/bin/env sh
# (Re)crée la base de données à partir du dump db/dump.sql.

mkdir -p site/databases
chmod a+w site/databases

rm site/databases/database.sqlite 2>/dev/null
sqlite3 site/databases/database.sqlite < db/dump.sql
chmod a+w site/databases/database.sqlite
