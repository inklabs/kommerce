#!/usr/bin/env bash

vagrant ssh -c "cd /vagrant; tests/codecept run --html $@"
