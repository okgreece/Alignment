FROM php:7.2.3-apache

RUN apt-get -y update && apt-get install -y git bash gettext curl mysql-client zip unzip libpng-dev libxml2-dev libxslt1-dev

RUN apt-get update && apt-get install -y --no-install-recommends \
		bzip2 \
		unzip \
		xz-utils \
	&& rm -rf /var/lib/apt/lists/*

RUN apt-get update && \
    docker-php-ext-install -j$(nproc) pdo_mysql gd xml json xsl zip mbstring

# fix man pages issue https://github.com/debuerreotype/docker-debian-artifacts/issues/24
RUN mkdir -p /usr/share/man/man1

#https://stackoverflow.com/questions/31196567/installing-java-in-docker-image
# Install OpenJDK-8
RUN apt-get update && \
    apt-get install -y openjdk-8-jdk && \
    apt-get install -y ant && \
    apt-get clean;

# Fix certificate issues
RUN apt-get update && \
    apt-get install -y ca-certificates-java && \
    apt-get clean && \
    update-ca-certificates -f;

# Setup JAVA_HOME -- useful for docker commandline
ENV JAVA_HOME /usr/lib/jvm/java-8-openjdk-amd64/
RUN export JAVA_HOME

RUN git config --global url."https://github.com/".insteadOf git@github.com: && \
    git config --global url."https://".insteadOf git://

# Install Composer:
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install additional packages:
RUN apt-get update && apt-get install -y libraptor2-dev supervisor

# Enable Apache mod_rewrite
RUN a2enmod rewrite
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

COPY .env $APP_DIR/.env

RUN composer install 
 
RUN supervisord && supervisorctl reread && supervisorctl update && supervisorctl start alignment-listener:*
EXPOSE 80

RUN touch $APP_DIR/storage/logs/laravel.log $APP_DIR/storage/logs/worker.log && chmod a+rwx $APP_DIR/storage/logs/laravel.log $APP_DIR/storage/logs/worker.log
RUN chmod -R 777 $APP_DIR/bootstrap $APP_DIR/storage $APP_DIR/public
COPY ./start.sh $APP_DIR/start.sh
RUN chmod a+x $APP_DIR/start.sh
