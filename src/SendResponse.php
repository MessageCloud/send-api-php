<?php

namespace MessageCloud\Send;

class SendResponse
{
    public function __construct(
        public string $id,
        public string $status,
        public int $statusCode,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function wasSuccessful(): bool
    {
        return 0 === $this->statusCode;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public static function fromResponseBody(string $result): SendResponse
    {
        /** @var \stdClass $json */
        $json = json_decode(json: $result, flags: JSON_THROW_ON_ERROR);

        return new SendResponse($json->id, $json->status, $json->status_code);
    }
}
