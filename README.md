Kommerce
========

Kohana PHP E-commerce Platform

## Introduction

Zen Kommerce is a PHP shopping cart system written in the Kohana framework.
More information can be found [here](http://inklabs.github.io/kommerce/).

## Vagrant Setup

<pre>
	vagrant up
</pre>

* Then visit [http://127.0.0.1:4567](http://127.0.0.1:4567)

## Local Setup

* Download Maxmind DB

<pre>
	./run_minion.sh "--task=Maxmind:GeoLite2 --city=1"
</pre>

## Code Tests

* Codeception
	- All acceptance tests are verified to work with the PhpBrowser.
	- http://codeception.com/quickstart

<pre>
	# run all tests from the project root
	./run_tests.sh

	# run only unit tests
	./run_tests.sh unit

	# run only acceptance tests
	./run_tests.sh acceptance

	# run single test
	./run_tests.sh tests/acceptance/101WelcomeCept.php
	./run_tests.sh "tests/acceptance/101WelcomeCept.php --steps"
</pre>

* Selenium
	- You can run the acceptance tests in Selenium; however, not all tests are verified to work.
	- Edit tests/acceptance.suite.yml to enable Selenium2 and comment out PhpBrowser and WebHelper.

<pre>
	SELENIUM=selenium-server-standalone-2.33.0.jar
	wget http://selenium.googlecode.com/files/$SELENIUM
	mv $SELENIUM ~/bin/
	chmod +x ~/bin/

	# in a separate terminal
	java -jar ~/bin/$SELENIUM
</pre>

## Articles

- [Intro to Vagrant with Kohana and Zen Kommerce](http://blog.jamieisaacs.com/2014/03/04/intro-to-vagrant-with-kohana-and-zen-kommerce/) - March 4, 2014
- [Intro to Maxmind GeoLite2 with Kohana](http://blog.jamieisaacs.com/2014/03/10/intro-to-maxmind-geolite2-with-kohana/) - March 10, 2014
- [Redis Sessions in PHP with Kohana](http://blog.jamieisaacs.com/2014/03/17/redis-sessions-in-php-with-kohana/) - March 17, 2014

## License

[Copyright Ink Labs, LLC](https://github.com/inklabs/kommerce/blob/master/license.txt)
All Rights Reserved.
