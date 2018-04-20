#!/usr/bin/env bash
# Install App:
cd $APP_DIR
php artisan key:generate
chmod -R a+rwx $APP_DIR


# Configure PHP date.timezone
#echo "date.timezone = $PHP_TIMEZONE" > /usr/local/etc/php/conf.d/timezone.ini

# Inject environemt variables into config file:
envsubst < "$APP_DIR/.env" > "$APP_DIR/.env_injected"
mv "$APP_DIR/.env_injected" "$APP_DIR/.env"

cp deployment/default_config.xml storage/app/projects/default_config.xml
cp deployment/LinkSpecificationLanguage.xsd storage/app/projects/LinkSpecificationLanguage.xsd
cp deployment/owl2skos.cfg storage/app/projects/owl2skos.cfg

php artisan migrate --seed

# Configure Apache Document Root
chown -R www-data:www-data $APP_DIR/storage
mkdir -p $APP_DIR/public/system && chown -R www-data:www-data $APP_DIR/public/system
mkdir -p /var/www/.silk && chown -R www-data:www-data /var/www/.silk

chmod a+rwx -R $APP_DIR

supervisord
