#!/usr/bin/env bash
set -x #echo on

# libmcrypt (for PHP)
cd /usr/local/src
wget http://downloads.sourceforge.net/project/mcrypt/Libmcrypt/2.5.8/libmcrypt-2.5.8.tar.gz
tar zxf libmcrypt-2.5.8.tar.gz
cd libmcrypt-2.5.8
./configure \
   --prefix=/usr/local \
   --libdir=/lib64 \
   --disable-posix-threads \
   --enable-dynamic-loading && \
make && make install

# PHP
PHP_NAME=php-5.5.9
cd /usr/local/src
wget http://us.php.net/get/$PHP_NAME.tar.gz/from/this/mirror
tar zxf $PHP_NAME.tar.gz
cd $PHP_NAME
./configure \
   --host=x86_64-redhat-linux-gnu \
   --prefix=/usr/local \
   --disable-cgi \
   --disable-rpath \
   --with-config-file-path=/etc \
   --with-bz2 \
   --with-curl \
   --with-gd \
   --with-jpeg-dir \
   --with-png-dir \
   --with-zlib \
   --with-xpm-dir \
   --with-freetype-dir \
   --with-gmp \
   --with-iconv \
   --with-libdir=lib64 \
   --with-mcrypt \
   --with-mhash \
   --with-mysql=mysqlnd \
   --with-mysqli=mysqlnd \
   --with-pdo-mysql=mysqlnd \
   --with-pcre-regex \
   --with-pear \
   --with-openssl \
   --with-readline \
   --with-xmlrpc \
   --with-gettext \
   --with-fpm-user=www-data \
   --with-fpm-group=www-data \
   --enable-opcache \
   --enable-fpm \
   --enable-bcmath \
   --enable-calendar \
   --enable-cli \
   --enable-dba \
   --enable-exif \
   --enable-ftp \
   --enable-gd-native-ttf \
   --enable-inline-optimization \
   --enable-mbstring \
   --enable-shmop \
   --enable-soap \
   --enable-sockets \
   --enable-sysvmsg \
   --enable-sysvsem \
   --enable-sysvshm \
   --enable-zip && \
make && make install

cp /usr/local/src/php-5.5.9/sapi/fpm/init.d.php-fpm /etc/init.d/php-fpm
cp /vagrant/vagrant/php/php-fpm.conf /usr/local/etc/
chmod +x /etc/init.d/php-fpm

# php-gearman
PHPGEARMAN_NAME=gearman-1.1.2
cd /usr/local/src
wget http://pecl.php.net/get/$PHPGEARMAN_NAME.tgz
tar zxf $PHPGEARMAN_NAME.tgz
cd $PHPGEARMAN_NAME
phpize
./configure && \
make && make install

# igbinary for phpredis
cd /usr/local/src
wget http://pecl.php.net/get/igbinary-1.1.1.tgz
tar zxf igbinary-1.1.1.tgz
cd igbinary-1.1.1
phpize
./configure && \
make && make install

# php-redis
cd /usr/local/src
wget http://pecl.php.net/get/redis-2.2.4.tgz
tar zxf redis-2.2.4.tgz
cd redis-2.2.4
phpize
./configure --enable-redis-igbinary && \
make && make install

# libmaxminddb for php-maxmind
cd /usr/local/src
wget https://github.com/maxmind/libmaxminddb/archive/0.5.3.zip -O libmaxminddb-0.5.3.zip
unzip libmaxminddb-0.5.3.zip
cd libmaxminddb-0.5.3
./bootstrap
./configure && \
make && make install
ldconfig /usr/local/lib/
# echo "/usr/local/lib" >> /etc/ld.so.conf.d/usrlocal.conf

# php-maxmind
cd /usr/local/src
wget https://github.com/maxmind/MaxMind-DB-Reader-php/archive/v0.3.0.zip -O MaxMind-DB-Reader-php-0.3.0.zip
unzip MaxMind-DB-Reader-php-0.3.0.zip
cd MaxMind-DB-Reader-php-0.3.0/ext
phpize
./configure && \
make && make install

# Finalize PHP
cp /vagrant/vagrant/php/php.ini /etc/
service php-fpm start
chkconfig php-fpm on
