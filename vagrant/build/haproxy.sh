#!/usr/bin/env bash
set -x #echo on

yum install -y haproxy
cp /vagrant/vagrant/haproxy/haproxy.cfg /etc/haproxy/haproxy.cfg
service haproxy start
chkconfig haproxy on
