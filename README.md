rpssl
=====

This is a game of Rock, Paper, Scissors, Spock, Lizard.
It is based on http://www.samkass.com/theories/RPSSL.html

Installation
------------
~~~code
git clone https://github.com/matuck/rpssl.git
cd rpssl
composer install
bower install
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
~~~

