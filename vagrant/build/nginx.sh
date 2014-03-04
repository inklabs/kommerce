#!/usr/bin/env bash
set -x #echo on

# Nginx Setup
cp /vagrant/vagrant/nginx/nginx.repo /etc/yum.repos.d/
yum install -y nginx
chkconfig nginx on
mv /etc/nginx/conf.d/default.conf{,.bak}
cp /vagrant/vagrant/nginx/kommerce.conf /etc/nginx/conf.d/
service nginx start
