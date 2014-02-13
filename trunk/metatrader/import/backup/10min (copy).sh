#!/bin/bash

echo "Running Import";
cd /var/www/import/logo600
php -f import.php

echo "Running Import";
cd /var/www/import/lospaccone76
php -f import.php

echo "Running Import";
cd /var/www/import/malsolo
php -f import.php

echo "Running Import";
cd /var/www/import/lorenoem
php -f import.php

echo "Running Import";
cd /var/www/import/rowaihy
php -f import.php

echo "Running Import";
cd /var/www/import/ykforex
php -f import.php

echo "Running Import";
cd /var/www/import/axitrader
wget http://www.myfxbook.com/statements/743390/statement.csv
mv statement.csv axitrader.csv
chmod 777 axitrader.csv
php -f axitraderimport.php 

echo "Running Import";
cd /var/www/import/johnpaul
wget http://www.myfxbook.com/statements/786533/statement.csv
mv statement.csv johnpaul77.csv
chmod 777 johnpaul77.csv
php -f johnpaulimport.php 

echo "Running Import";
cd /var/www/import/wallstreet
wget http://www.myfxbook.com/statements/95290/statement.csv
mv statement.csv wallstreet.csv
chmod 777 wallstreet.csv
php -f wallstreetimport.php 

