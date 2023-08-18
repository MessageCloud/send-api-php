# MessageCloud Send PHP SDK
The MessageCloud Send PHP SDK provides a convenient way to interact with the MessageCloud Send API for sending SMS messages.

## Installation
To use the MessageCloud Send PHP SDK in your project, follow these steps:

Install Composer if you haven't already:

```bash
curl -sS https://getcomposer.org/installer | php

mv composer.phar /usr/local/bin/composer
```

Create a composer.json file in your project directory and add the following dependency:

```json
{
    "require": {
        "messagecloud/send-api-php": "^1.0"
    }
}
```

Run Composer to install the dependencies:

```bash
composer install
```

If you already have composer in your project then it's as simple as this:

```bash
composer require messagecloud/send-api-php
```

## Authentication
To use the SDK, you need to create an instance of the Authentication class with your username and password:

```php
use MessageCloud\Send\Authentication;

$authentication = new Authentication('your-username', 'your-password');
```

## Sending SMS
To send an SMS message using the SDK, create an instance of the Sms class and pass the required parameters:

```php
use MessageCloud\Send\Sms;

$message = new Sms('1234567890', 'sender', 'Hello, world!');
```

Then, create an instance of the Client class and send the SMS:

```php
use MessageCloud\Send\Client;

$client = new Client($authentication);
$response = $client->send($message);

if ($response->wasSuccessful()) {
    echo "SMS sent successfully. ID: " . $response->getId();
} else {
    echo "Failed to send SMS. Status: " . $response->getStatus();
}
```

## Running Tests
To run unit tests for the SDK, you can use PHPUnit. Make sure you have PHPUnit installed:

```bash
composer require --dev phpunit/phpunit
```

Then, you can run the tests:

```bash
vendor/bin/phpunit
```

## Code Quality Checks
This project uses PHPStan and PHP CS Fixer for code quality checks. You can run them using the following commands:

To analyze code with PHPStan:

```bash
vendor/bin/phpstan analyse
```

To fix coding standards violations with PHP CS Fixer:

```bash
vendor/bin/php-cs-fixer fix --dry-run --stop-on-violation
```

## Contributing
If you find a bug or would like to contribute to this SDK, feel free to open an issue or submit a pull request.

## License
This SDK is open-source software licensed under the BSD-2-Clause License. See the LICENSE file for more information.
