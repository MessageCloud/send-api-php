<?php

require_once __DIR__.'/../vendor/autoload.php';

$sms = new MessageCloud\Send\Sms(
    to: '447528748500',
    from: 'MsgCloud',
    message: 'Hello, world!',
    sendAt: new DateTime('+1 hour'),
);

$authentication = new MessageCloud\Send\Authentication(
    username: 'msgcloud',
    password: 'password',
);

$client = new MessageCloud\Send\Client($authentication);

try {
    $response = $client->send($sms);

    if ($response->wasSuccessful()) {
        // SMS sent successfully

        // now store $response->getId() for your records...
    } else {
        // SMS was not sent

        // check the $response->getStatus() for a reason why this happened
    }
} catch (Throwable $throwable) {
    // could not send SMS
}
