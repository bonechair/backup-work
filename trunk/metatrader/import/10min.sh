#!/bin/bash


yest=$(date --date="yesterday" +"%Y-%m-%d")
tom=$(date --date="tomorrow" +"%Y-%m-%d")
datestr="?start=${yest}&end=${tom}"

echo "Running Import";
cd /var/www/import/wallstreet
wget --output-document=wallstreet.csv http://www.myfxbook.com/statements/95290/statement.csv"$datestr"
chmod 777 wallstreet.csv
php -f wallstreetimport.php 

echo "Running Import";
cd /var/www/import/axitrader
wget --output-document=axitrader.csv http://www.myfxbook.com/statements/743390/statement.csv"$datestr"
chmod 777 axitrader.csv
php -f axitraderimport.php 

echo "Running Import";
cd /var/www/import/johnpaul
wget --output-document=johnpaul77.csv http://www.myfxbook.com/statements/786533/statement.csv"$datestr"
chmod 777 johnpaul77.csv
php -f johnpaulimport.php 

echo "Running Import";
cd /var/www/import/fst-eurusd
wget --output-document=fst-eurusd.csv http://www.myfxbook.com/statements/220306/statement.csv"$datestr"
chmod 777 fst-eurusd.csv
php -f import.php 


echo "Running Import";
cd /var/www/import/black-sun
wget --output-document=black-sun.csv http://www.myfxbook.com/statements/795345/statement.csv"$datestr"
chmod 777 black-sun.csv
php -f import.php 

echo "Running Import";
cd /var/www/import/trader2013-1
wget --output-document=trader2013-1.csv http://www.myfxbook.com/statements/600503/statement.csv"$datestr"
chmod 777 trader2013-1.csv
php -f import.php 

echo "Running Import";
cd /var/www/import/wallstreet-demo
wget --output-document=wallstreet-demo.csv http://www.myfxbook.com/statements/95294/statement.csv"$datestr"
chmod 777 wallstreet-demo.csv
php -f import.php 

echo "Running csv generate";
cd /var/www/import/
rm signals.csv
mysql -ubonechair -pediter888 mysignals -e  "SELECT id, opendate, closedate, op, cp, tp, st, trade, symbol FROM signals WHERE (trade = 'Sell' || trade = 'Buy') GROUP by symbol, opendate, author ORDER by opendate DESC LIMIT 3000  INTO OUTFILE '/var/www/import/signals.csv' FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n'"
cp signals.csv /var/www/import/metatrader/tester/files/signals.csv
cp signals.csv /var/www/import/metatrader/experts/files/signals.csv
