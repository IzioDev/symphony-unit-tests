# Setting everything up:
* `git clone https://github.com/izio38/symphony-unit-tests.git`
* `cd symphony-unit-tests`
* `composer install`

# Running the application:
* `symfony serve` - inside the project root directory.

# Running the test cases:
### Without Coverage:
* `./bin/phpunit`
### With Coverage:
* `./bin/phpunit --coverage-html coverage`