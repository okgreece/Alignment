FROM php:7.0.13-apache

RUN echo "deb http://ftp.de.debian.org/debian jessie-backports main" >> /etc/apt/sources.list

RUN apt-get -y update && apt-get install -y git bash gettext curl mysql-client zip unzip
RUN apt install -y -t jessie-backports openjdk-8-jre-headless openjdk-8-jdk-headless openjdk-8-jdk ca-certificates-java

RUN echo 'deb http://packages.dotdeb.org jessie all' > /etc/apt/sources.list.d/dotdeb.list
RUN curl http://www.dotdeb.org/dotdeb.gpg | apt-key add -
RUN apt-get update -y && \
    apt-get install -y php7.0-mysql && \
    docker-php-ext-install pdo_mysql

RUN git config --global url."https://github.com/".insteadOf git@github.com: && \
    git config --global url."https://".insteadOf git://

# Install Composer:
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install additional packages:
RUN apt-get install -y php7.0-gd libapache2-mod-php7.0 \
    php7.0-xml php7.0-json php7.0-xsl php7.0-redis php7.0-mcrypt \
    php7.0-imagick php7.0-common php7.0-zip libpng-dev libraptor2-dev supervisor

# Install mbstring
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install gd

RUN phpenmod gd

# Enable Apache mod_rewrite
RUN a2enmod rewrite
RUN a2enmod php7.0
RUN a2enmod proxy
RUN a2enmod proxy_http
RUN a2enmod actions
# apache enable ssl
RUN a2enmod ssl

# Install app:
# Configure Apache Document Root
ENV APACHE_DOC_ROOT /var/www/alignment/public/
ENV APP_DIR /var/www/alignment
      
COPY ./php.ini /etc/php/7.0/apache2/php.ini
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./listener.conf /etc/supervisor/conf.d/listener.conf

WORKDIR $APP_DIR

RUN curl https://api.github.com/repos/okgreece/Alignment/git/refs/heads/develop/1 -o version.json
RUN rm -r $APP_DIR
RUN git clone -bdevelop/1 https://github.com/okgreece/Alignment.git $APP_DIR/

RUN composer install 
#RUN cp deployment/default_config.xml storage/app/projects/default_config.xml
#RUN cp deployment/LinkSpecificationLanguage.xsd storage/app/projects/LinkSpecificationLanguage.xsd


COPY ./.env $APP_DIR/.env 
RUN supervisord && supervisorctl reread && supervisorctl update && supervisorctl start alignment-listener:*
EXPOSE 80

RUN touch $APP_DIR/storage/logs/laravel.log $APP_DIR/storage/logs/worker.log && chmod a+rwx $APP_DIR/storage/logs/laravel.log $APP_DIR/storage/logs/worker.log

COPY ./start.sh $APP_DIR/start.sh
RUN chmod a+x $APP_DIR/start.sh