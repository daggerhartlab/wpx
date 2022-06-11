#!/usr/bin/env bash

# wp-config.php
./vendor/bin/wp config create \
  --dbname=wordpress \
  --dbuser=wordpress \
  --dbpass=wordpress \
  --dbhost=database \
  --config-file=./wp-config.php \
  > /dev/null 2>&1 || true
./vendor/bin/wp config set __composer_class_loader "require_once __DIR__ . '/vendor/autoload.php'" --anchor="<?php" --placement=after --type=variable --add --raw
./vendor/bin/wp config set WP_DEBUG true --add --raw
./vendor/bin/wp config set WP_DEBUG_DISPLAY true --add --raw
./vendor/bin/wp config set ABSPATH "__DIR__ . '/wp/'" --add --raw
./vendor/bin/wp config set WP_HOME "https://$LANDO_APP_NAME.lndo.site" --add
./vendor/bin/wp config set WP_SITEURL "WP_HOME . '/wp'" --add --raw
./vendor/bin/wp config set WP_CONTENT_DIR "__DIR__ . '/wp-content'" --add --raw
./vendor/bin/wp config set WP_CONTENT_URL "WP_HOME . '/wp-content'" --add --raw

# Database
./vendor/bin/wp db clean --yes
./vendor/bin/wp core install --title=$LANDO_APP_NAME --url=$LANDO_APP_NAME.lndo.site --admin_user=admin --admin_email=$LANDO_APP_NAME@d.com --admin_password=pass
./vendor/bin/wp rewrite structure "/%postname%/"

# Plugins & themes
./vendor/bin/wp plugin activate --all
./vendor/bin/wp theme install twentytwentytwo --activate
