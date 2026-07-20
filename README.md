Readme:

1- Creer le dossier writable si n'existe pas:
mkdir -p writable

2- Creer la base:

sqlite3 writable/mobile_money.db < base.sql

3- Puis lancer php:

php spark serve
