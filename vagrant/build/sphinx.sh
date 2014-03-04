#!/usr/bin/env bash
set -x #echo on

# Sphinx
cd /usr/local/src
wget http://sphinxsearch.com/files/sphinx-2.1.5-1.rhel6.x86_64.rpm
yum -y localinstall sphinx-2.1.5-1.rhel6.x86_64.rpm
cp /vagrant/vagrant/sphinx/sphinx.conf /etc/sphinx/sphinx.conf

# Run Sphinx indexer
/usr/bin/indexer --all

service searchd start
chkconfig searchd on
