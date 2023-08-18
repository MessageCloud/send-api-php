<?php

namespace MessageCloud\Send;

use MessageCloud\Send\Interfaces\UriQueryable;
use MessageCloud\Send\Interfaces\Validatable;

class Sms implements UriQueryable, Validatable
{
    /**
     * @var string[]
     */
    protected array $validation = [
        'to' => '/^\d{6,13}$/',
        'from' => '/^.{1,11}$/',
        'message' => '/.+/',
    ];

    public function __construct(
        protected string $to,
        protected string $from,
        protected string $message,
        protected ?\DateTime $expireAt = null,
        protected ?\DateTime $sendAt = null,
        protected ?string $deliveryReportUrl = null,
        protected ?int $deliveryReportLevel = null
    ) {
    }

    /**
     * @return mixed[]
     */
    public function getUriQueryParams(): array
    {
        return array_filter([
            'to' => $this->to,
            'from' => $this->from,
            'message' => $this->message,
            'expire_at' => !is_null($this->expireAt) ? $this->expireAt->format('c') : null,
            'send_at' => !is_null($this->sendAt) ? $this->sendAt->format('c') : null,
            'dlr_url' => $this->deliveryReportUrl,
            'dlr_verbosity' => $this->deliveryReportLevel,
        ], fn ($value) => !is_null($value) && '' !== $value);
    }

    public function validate(): bool
    {
        foreach ($this->validation as $param => $regex) {
            if (!preg_match($regex, $this->$param)) {
                return false;
            }
        }

        return true;
    }
}
