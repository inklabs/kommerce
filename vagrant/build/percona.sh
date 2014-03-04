#!/usr/bin/env bash
set -x #echo on

# Percona Server
yum install -y http://www.percona.com/downloads/percona-release/percona-release-0.0-1.x86_64.rpm
yum install -y Percona-Server-server-56
chkconfig mysql on
service mysql start
