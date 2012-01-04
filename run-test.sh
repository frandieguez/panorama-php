#!/bin/sh
if [ ! -f behat.phar ]; then
	wget https://github.com/downloads/Behat/Behat/behat.phar
fi
php behat.phar features
exit $?
