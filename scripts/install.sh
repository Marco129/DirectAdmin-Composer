#!/bin/sh
PLUGINPATH=/usr/local/directadmin/plugins/directadmin-composer

COMPOSER_HOME=${PLUGINPATH}/data
if [ ! -f ${PLUGINPATH}/data/composer.phar ]; then
    curl -sS https://getcomposer.org/installer | php -- --install-dir=${PLUGINPATH}/data --quiet
else
    php ${PLUGINPATH}/data/composer.phar self-update --quiet
fi

for dir in data hooks images includes user; do {
    chmod -R 755 ${PLUGINPATH}/${dir}
    chown -R diradmin:diradmin ${PLUGINPATH}/${dir}
}
done;

chmod -R 700 ${PLUGINPATH}/scripts
chown -R diradmin:diradmin ${PLUGINPATH}/scripts

echo 'Plugin is now installed!';
exit 0;
