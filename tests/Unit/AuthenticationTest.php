<?php

namespace UnitTests\Send;

use MessageCloud\Send\Authentication;
use PHPUnit\Framework\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * @return mixed[][]
     */
    public static function authenticationDataProvider(): array
    {
        return [
            ['valid_username', 'valid_password', true],
            ['another_valid', '123456', true],
            ['', 'valid_password', false],
            ['valid_username', '', false],
        ];
    }

    /**
     * @dataProvider authenticationDataProvider
     */
    public function testAuthenticationValidation(string $username, string $password, bool $expected): void
    {
        $auth = new Authentication($username, $password);

        $this->assertEquals($expected, $auth->validate());
    }

    public function testGetUriQueryParams(): void
    {
        $username = 'test_username';
        $password = 'test_password';

        $auth = new Authentication($username, $password);

        $expectedParams = [
            'username' => $username,
            'password' => $password,
        ];

        $this->assertEquals($expectedParams, $auth->getUriQueryParams());
    }
}
