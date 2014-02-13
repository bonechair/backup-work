#!/bin/bash

echo "Running csv generate";
cd /var/www/import/
rm signals.csv
mysql -ubonechair -pediter888 mysignals -e  "SELECT id, opendate, closedate, op, cp, tp, st, trade, symbol FROM signals (LOWER(trade) LIKE '%sell%' || LOWER(trade) LIKE '%buy%') ORDER by opendate DESC LIMIT 9000  INTO OUTFILE '/var/www/import/signals.csv' FIELDS TERMINATED BY ',' LINES TERMINATED BY '\n'"
cp signals.csv /var/www/import/metatrader/tester/files/signals.csv
cp signals.csv /var/www/import/metatrader/experts/files/signals.csv
cp signals.csv /var/www/import/metatrader/MQL4/Files/signals.csv
chmod 777 /var/www/import/metatrader/MQL4/Files/signals.csv