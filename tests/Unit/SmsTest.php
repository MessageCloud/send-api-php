<?php

namespace UnitTests\Send;

use MessageCloud\Send\Sms;
use PHPUnit\Framework\TestCase;

class SmsTest extends TestCase
{
    /**
     * @return mixed[][]
     */
    public static function smsDataProvider(): array
    {
        return [
            ['1234567890', 'sender', 'Hello, world!', true],
            ['9876543210', 'from_user', 'Test message', true],

            ['abc', 'sender', 'Hello, world!', false],
            ['1234567890', '', 'Hello, world!', false],
            ['1234567890', 'sender', '', false],
        ];
    }

    /**
     * @dataProvider smsDataProvider
     */
    public function testValidSms(string $to, string $from, string $message, bool $expected): void
    {
        $sms = new Sms($to, $from, $message);

        $this->assertEquals($expected, $sms->validate());
    }

    public function testGetUriQueryParams(): void
    {
        $to = '1234567890';
        $from = 'sender';
        $message = 'Hello, world!';
        $expireAt = new \DateTime('+1 hour');
        $sendAt = new \DateTime('+2 hours');
        $deliveryReportUrl = 'https://test.com';
        $deliveryReportLevel = 2;

        $sms = new Sms($to, $from, $message, $expireAt, $sendAt, $deliveryReportUrl, $deliveryReportLevel);

        $queryParams = $sms->getUriQueryParams();

        $this->assertEquals($to, $queryParams['to']);
        $this->assertEquals($from, $queryParams['from']);
        $this->assertEquals($message, $queryParams['message']);
        $this->assertEquals($expireAt->format('c'), $queryParams['expire_at']);
        $this->assertEquals($sendAt->format('c'), $queryParams['send_at']);
        $this->assertEquals($deliveryReportUrl, $queryParams['dlr_url']);
        $this->assertEquals($deliveryReportLevel, $queryParams['dlr_verbosity']);
    }
}
