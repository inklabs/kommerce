#!/usr/bin/env bash
set -x #echo on

# Supervisord
easy_install supervisor
cp /vagrant/vagrant/gearman/supervisord.conf /etc/
cp /vagrant/vagrant/gearman/supervisord.init /etc/init.d/supervisord
chmod +x /etc/init.d/supervisord
service supervisord start
chkconfig --add supervisord
chkconfig supervisord on
