#!/usr/bin/env bash
set -x #echo on

# Fop
cd /usr/local/src
wget http://apache.cs.utah.edu/xmlgraphics/fop/binaries/fop-1.1-bin.tar.gz
tar zxf fop-1.1-bin.tar.gz
ln -s /usr/local/src/fop-1.1/fop /usr/local/bin/
