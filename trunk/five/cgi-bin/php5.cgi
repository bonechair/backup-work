#!/bin/bash
PHPRC=$DOCUMENT_ROOT/../etc/php5
export PHPRC
umask 022
SCRIPT_FILENAME=$PATH_TRANSLATED
export SCRIPT_FILENAME
exec /usr/bin/php-cgi
