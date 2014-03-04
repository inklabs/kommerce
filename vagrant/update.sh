#!/usr/bin/env bash
set -x #echo on

cp /vagrant/vagrant/nginx/kommerce.conf /etc/nginx/conf.d/
cp /vagrant/vagrant/php/php-fpm.conf /usr/local/etc/
cp /vagrant/vagrant/php/php.ini /etc/
cp /vagrant/vagrant/redis/redis.conf /etc/redis/
cp /vagrant/vagrant/sphinx/sphinx.conf /etc/sphinx/sphinx.conf
cp /vagrant/vagrant/gearman/supervisord.conf /etc/

service supervisord restart
service searchd restart
service redis-server restart
service php-fpm restart
service nginx restart

indexer --all --rotate
