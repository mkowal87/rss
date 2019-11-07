# RSS READER

This project is simple RSS reader of (Feed source: https://www.theregister.co.uk/software/headlines.atom)

## Installation
You can install it with Composer:
````
composer install
````

To provide data of dummy users please use fixture 
````
php bin/console doctrine:fixtures:load
````

## Features
* User Registration, with Ajax call to check available emails
* User Login
* RSS Feed reader (excluding 50 most used english words)

## Author
Maciej Kowal