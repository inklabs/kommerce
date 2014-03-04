#!/usr/bin/env bash
set -x #echo on

# Gearmand
GEARMAN_NAME=gearmand-1.1.12
cd /usr/local/src
wget https://launchpad.net/gearmand/1.2/1.1.12/+download/$GEARMAN_NAME.tar.gz
tar zxf $GEARMAN_NAME.tar.gz
cd $GEARMAN_NAME
./configure && \
make && make install
cp /vagrant/vagrant/gearman/gearmand.init /etc/init.d/gearmand
chmod +x /etc/init.d/gearmand
adduser gearmand
mkdir -p /usr/local/var/log
touch /usr/local/var/log/gearmand.log
chown gearmand.gearmand /usr/local/var/log/gearmand.log
mkdir /var/run/gearmand
chkconfig --add gearmand
chkconfig gearmand on
service gearmand start
