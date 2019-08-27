Description (originally by smtripat, but hacked by me to within an inch of its life.)
==================
This Image serves the purpose of testing your Application with Apache 2.4.7 and Php-Fpm-7 before upgrading your Apache and Php for optimal performance...<snip>...Configuration has been crafted keeping in view CGI application vulnerability. This image outputs the logs to stdout and runs apache as site user. The image is immune to *httpoxy vulnerability*.

*The Image size is 87.82 MB and uses alpine3.5 as base image*
now it's only 36.4 MB by removing vim, curl, git etc...

// TODO - change the commands below!

To Start the Container
-------------------------------
```docker run --name apache smtripat/alpine-apache-php-fpm:latest```

To make the container listen on host port 80
```docker run -p 80:80 -d --name apache smtripat/alpine-apache-php-fpm:latest```


To get Shell Access inside the container
------------------------------------
To get access as site user
```docker exec -it <container-name> su site````

To get access as root user
```docker exec -it <container-name> /bin/ash```

