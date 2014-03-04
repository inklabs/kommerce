#!/usr/bin/env bash
set -x #echo on

PATH=/usr/local/bin:$PATH

iptables -I INPUT 5 -m state --state NEW -p tcp --dport 80 -j ACCEPT
iptables -I INPUT 5 -m state --state NEW -p tcp --dport 5000 -j ACCEPT
service iptables save

cp /usr/share/zoneinfo/UTC /etc/localtime

service ntpdate start
chkconfig ntpdate on

# yum update

yum install -y make gcc cc \
 uuid-devel libuuid libuuid-devel uuid boost-devel libevent libevent-devel \
 gperf libxml2-devel bzip2-devel libcurl-devel libjpeg-devel libpng-devel \
 libXpm-devel freetype-devel gmp-devel libtool-ltdl-devel \
 java-1.6.0-openjdk ImageMagick \
 python-setuptools nc libtool ntp

/vagrant/vagrant/build/percona.sh
/vagrant/vagrant/build/fop.sh
/vagrant/vagrant/build/redis.sh
/vagrant/vagrant/build/gearmand.sh
/vagrant/vagrant/build/sphinx.sh
/vagrant/vagrant/build/php.sh
/vagrant/vagrant/build/nginx.sh
/vagrant/vagrant/build/haproxy.sh
/vagrant/vagrant/build/supervisord.sh

echo 'Nginx: http://127.0.0.1:4567'
echo 'Haproxy: http://127.0.0.1:4568'
echo 'MySQL via SSH:'
echo '  SSH Host: 127.0.0.1'
echo '  SSH Port: 2222'
echo '  SSH User: vagrant'
echo '  SSH Pass: vagrant'
echo
echo '  MySQL Host: 127.0.0.1'
echo '  MySQL Port: 3306'
echo '  MySQL User: root'
echo '  MySQL Pass: (none)'
echo '  MySQL Database: kommerce'
