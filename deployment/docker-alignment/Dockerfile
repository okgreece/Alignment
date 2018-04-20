FROM php:7.2.3-apache

RUN apt-get -y update && apt-get install -y git bash gettext curl mysql-client zip unzip libpng-dev libxml2-dev libxslt1-dev

RUN apt-get update && apt-get install -y --no-install-recommends \
		bzip2 \
		unzip \
		xz-utils \
	&& rm -rf /var/lib/apt/lists/*

# Default to UTF-8 file.encoding
ENV LANG C.UTF-8

# add a simple script that can auto-detect the appropriate JAVA_HOME value
# based on whether the JDK or only the JRE is installed
RUN { \
		echo '#!/bin/sh'; \
		echo 'set -e'; \
		echo; \
		echo 'dirname "$(dirname "$(readlink -f "$(which javac || which java)")")"'; \
	} > /usr/local/bin/docker-java-home \
	&& chmod +x /usr/local/bin/docker-java-home

# do some fancy footwork to create a JAVA_HOME that's cross-architecture-safe
RUN ln -svT "/usr/lib/jvm/java-8-openjdk-$(dpkg --print-architecture)" /docker-java-home
ENV JAVA_HOME /docker-java-home/jre

ENV JAVA_VERSION 8u162
ENV JAVA_DEBIAN_VERSION 8u162-b12-1~deb9u1

# see https://bugs.debian.org/775775
# and https://github.com/docker-library/java/issues/19#issuecomment-70546872
ENV CA_CERTIFICATES_JAVA_VERSION 20170531+nmu1

RUN set -ex; \
	\
# deal with slim variants not having man page directories (which causes "update-alternatives" to fail)
	if [ ! -d /usr/share/man/man1 ]; then \
		mkdir -p /usr/share/man/man1; \
	fi; \
	\
	apt-get update; \
	apt-get install -y \
		openjdk-8-jre-headless="$JAVA_DEBIAN_VERSION" \
		ca-certificates-java="$CA_CERTIFICATES_JAVA_VERSION" \
	; \
	rm -rf /var/lib/apt/lists/*; \
	\
# verify that "docker-java-home" returns what we expect
	[ "$(readlink -f "$JAVA_HOME")" = "$(docker-java-home)" ]; \
	\
# update-alternatives so that future installs of other OpenJDK versions don't change /usr/bin/java
	update-alternatives --get-selections | awk -v home="$(readlink -f "$JAVA_HOME")" 'index($3, home) == 1 { $2 = "manual"; print | "update-alternatives --set-selections" }'; \
# ... and verify that it actually worked for one of the alternatives we care about
	update-alternatives --query java | grep -q 'Status: manual'

# see CA_CERTIFICATES_JAVA_VERSION notes above
RUN /var/lib/dpkg/info/ca-certificates-java.postinst configure

# If you're reading this and have any feedback on how this image could be
# improved, please open an issue or a pull request so we can discuss it!
#
#   https://github.com/docker-library/openjdk/issues

#RUN echo 'deb http://packages.dotdeb.org jessie all' > /etc/apt/sources.list.d/dotdeb.list
#RUN curl http://www.dotdeb.org/dotdeb.gpg | apt-key add -

RUN apt-get update && \
    docker-php-ext-install -j$(nproc) pdo_mysql gd xml json xsl zip mbstring

RUN git config --global url."https://github.com/".insteadOf git@github.com: && \
    git config --global url."https://".insteadOf git://

# Install Composer:
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install additional packages:
RUN apt-get update && apt-get install -y libraptor2-dev supervisor python-pip
RUN pip install skosify
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

RUN git clone https://github.com/okgreece/Alignment.git $APP_DIR/
RUN git checkout 60e0e463c196be016e7873138832e88ee59b73c3
COPY ./.env $APP_DIR/.env 

RUN composer install 

RUN supervisord && supervisorctl reread && supervisorctl update && supervisorctl start alignment-listener:*
EXPOSE 80

RUN touch $APP_DIR/storage/logs/laravel.log $APP_DIR/storage/logs/worker.log && chmod a+rwx $APP_DIR/storage/logs/laravel.log $APP_DIR/storage/logs/worker.log
RUN chmod -R 777 $APP_DIR/bootstrap $APP_DIR/storage $APP_DIR/public
COPY ./start.sh $APP_DIR/start.sh
RUN chmod a+x $APP_DIR/start.sh