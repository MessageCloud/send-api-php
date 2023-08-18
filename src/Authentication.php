<?php

namespace MessageCloud\Send;

use MessageCloud\Send\Interfaces\UriQueryable;
use MessageCloud\Send\Interfaces\Validatable;

class Authentication implements UriQueryable, Validatable
{
    /**
     * @var array|string[]
     */
    protected array $validation = [
        'username' => '/^.{1,20}$/',
        'password' => '/^.{1,20}$/',
    ];

    public function __construct(
        public string $username,
        public string $password,
    ) {
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

    /**
     * @return string[]
     */
    public function getUriQueryParams(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}
