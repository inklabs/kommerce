#!/usr/bin/env bash
set -x #echo on

# Redis
REDIS_NAME=redis-2.8.5
cd /usr/local/src
wget http://download.redis.io/releases/$REDIS_NAME.tar.gz
tar zxf $REDIS_NAME.tar.gz
cd $REDIS_NAME
make && make install
mkdir /etc/redis /var/lib/redis
cp /vagrant/vagrant/redis/redis-server.init /etc/init.d/redis-server
cp /vagrant/vagrant/redis/redis.conf /etc/redis/
chmod +x /etc/init.d/redis-server
chkconfig --add redis-server
chkconfig redis-server on
service redis-server start
