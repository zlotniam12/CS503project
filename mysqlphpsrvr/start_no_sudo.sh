#!/bin/bash
docker run -it -p 8080:80 -p 8081:3306 -v $PWD/mysql:/tmp/mysql -v $PWD/php:/var/www/html zalyssa/cs503
