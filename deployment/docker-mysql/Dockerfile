FROM mysql:5.7

ENV MYSQL_DATABASE "alignment"

COPY ./my.cnf /etc/my.cnf

# Initializing DB for granting access to clients from another Host (aka Docker container):
COPY ./init.sh /docker-entrypoint-initdb.d/init.sh
RUN touch /docker-entrypoint-initdb.d/privileges.sql

EXPOSE 3306
