<?php

namespace MessageCloud\Send;

use MessageCloud\Send\Exceptions\CurlException;
use MessageCloud\Send\Exceptions\ResponseException;
use MessageCloud\Send\Exceptions\ValidationException;

class Client
{
    public const BASE_URL = 'https://send.messagecloud.io/sms';

    public function __construct(
        protected Authentication $authentication
    ) {
    }

    public function send(Sms $message): SendResponse
    {
        if (!$this->authentication->validate()) {
            throw new ValidationException('Authentication was not valid');
        }

        if (!$message->validate()) {
            throw new ValidationException('SMS parameters did not pass validation');
        }

        $params = array_merge($message->getUriQueryParams(), $this->authentication->getUriQueryParams());

        $ch = curl_init(self::BASE_URL.'?'.http_build_query($params));

        if (!$ch) {
            throw new CurlException('Could not initialise cURL library');
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HEADER => false,
        ]);

        /** @var string $result */
        $result = curl_exec($ch);

        if (!$result) {
            throw new ResponseException('No response was provided');
        }

        return SendResponse::fromResponseBody($result);
    }
}
