#!/bin/sh

docker run --rm --name=db_unit-tests -p 3306:3306 -v /home/docker/mysql-projet-symfony-unit-tests:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=pass -d mysql:5.7
