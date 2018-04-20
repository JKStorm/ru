# About
## Introduction
A simple microservice that is sent data via a POST request, and provides data via a series of GET requests.

## Design architecture
This app was designed using the microservices technique, part of the larger services orientated architectural style.

# Getting started
## Requirements

1) PHP7.0+
1) PHP7.0+ MySQL libraries
1) PHP7.0+ Memcache libraries
1) php-xml
1) php7.0-mbstring
1) Memcached
1) Composer
1) MySQL Server 5.7+

## How to

1) Create a database and use the `ru.sql` file in the projects root directory to create the required table structure
1) Clone the repo
1) In the projects root directory, run `composer install`
1) Set up a sensible configuration file at `src/settings.php`.
1) To use the builtin PHP webserver, from the projects root directory, run `php -S localhost:9000`
1) Make requests to http://localhost:9000

### Tests

1) Install composer dependencies
1) Run `./vendor/phpunit/phpunit/phpunit` from the projects root directory

# Nice to have if time permitted

1) Improve PHPUnit test coverage
1) Normalize the match table further; split out season, sport, competition and teams into their own entities with links
1) Make the retrieval of XML use a queue and proper HTTP client - E.g. RabbitMQ and Guzzle
1) Authentication middleware
1) Rate limiting/throttling middleware
1) Swagger API docs
1) Add some integration tests - Behat
1) Graylog
1) Portable development and/or production environments - vagrant and/or docker
1) DB migrations rather than a SQL file
1) Add return type declarations
1) Improve the memory performance of App\Parser\Submit by using Xpath for querying
1) Add memcache to cache requests to the api endpoint