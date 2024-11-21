ARG BASE_IMAGE=php:8.2-fpm
FROM $BASE_IMAGE
SHELL ["/bin/bash", "-c"]

ARG username=webuser
ARG uid=1000
ARG gid=1000
ARG DDEV_PHP_VERSION
ARG DDEV_DATABASE

RUN (groupadd --gid $gid "$username" || groupadd "$username" || true) && \
    (useradd -l -m -s "/bin/bash" --gid "$username" --comment '' --uid $uid "$username" || \
    useradd -l -m -s "/bin/bash" --gid "$username" --comment '' "$username" || \
    useradd -l -m -s "/bin/bash" --gid "$gid" --comment '' "$username" || \
    useradd -l -m -s "/bin/bash" --comment '' $username)

### نصب Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

### DDEV-injected composer update
RUN export XDEBUG_MODE=off; composer self-update --stable || composer self-update --stable || true; \
    composer self-update --2 || composer self-update --2 || true

### DDEV-injected extra content
RUN mkdir -p /home/$username && \
    chown $username /home/$username && \
    touch /home/$username/.pgpass && \
    chmod 600 /home/$username/.pgpass

ENV NVM_DIR=/home/$username/.nvm

### DDEV-injected php folder permission fix
RUN chmod 777 /run/php
