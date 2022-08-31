# This dockerfile creates the docker image that is used in our ci pipeline.
# The image is currently hosted on DockerHub: https://hub.docker.com/r/maxsch1/moodle-ci
FROM moodlehq/moodle-php-apache:7.4
SHELL ["/bin/bash", "-c"]
# Install node
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash
RUN apt update && apt install -y nodejs default-mysql-client
# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
# Install Moodle ci plugin
RUN composer create-project -n --no-dev --prefer-dist moodlehq/moodle-plugin-ci ci ^3
RUN chmod u+x ci/bin/*
RUN umask u+x
