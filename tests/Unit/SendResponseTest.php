<?php

namespace UnitTests\Send;

use MessageCloud\Send\SendResponse;
use PHPUnit\Framework\TestCase;

class SendResponseTest extends TestCase
{
    public function testGetId(): void
    {
        $id = 'aca6b98f2a674e039c024332e5270a58';
        $response = new SendResponse($id, 'success', 0);

        $this->assertEquals($id, $response->getId());
    }

    public function testWasSuccessful(): void
    {
        $successResponse = new SendResponse('aca6b98f2a674e039c024332e5270a58', 'Request sent successfully', 0);
        $errorResponse = new SendResponse('aca6b98f2a674e039c024332e5270a58', 'Could not send request', 1);

        $this->assertTrue($successResponse->wasSuccessful());
        $this->assertFalse($errorResponse->wasSuccessful());
    }

    public function testGetStatus(): void
    {
        $status = 'success';
        $response = new SendResponse('aca6b98f2a674e039c024332e5270a58', $status, 0);

        $this->assertEquals($status, $response->getStatus());
    }

    public function testGetStatusCode(): void
    {
        $statusCode = 0;
        $response = new SendResponse('aca6b98f2a674e039c024332e5270a58', 'Request sent successfully', $statusCode);

        $this->assertEquals($statusCode, $response->getStatusCode());
    }

    public function testFromResponseBody(): void
    {
        $jsonResponse = '{"id": "aca6b98f2a674e039c024332e5270a58", "status": "Request sent successfully", "status_code": 0}';
        $response = SendResponse::fromResponseBody($jsonResponse);

        $this->assertInstanceOf(SendResponse::class, $response);
        $this->assertEquals('aca6b98f2a674e039c024332e5270a58', $response->getId());
        $this->assertEquals('Request sent successfully', $response->getStatus());
        $this->assertEquals(0, $response->getStatusCode());
    }

    /**
     * @dataProvider invalidJsonDataProvider
     */
    public function testFromResponseBodyWithInvalidJson(string $invalidJson): void
    {
        $this->expectException(\JsonException::class);

        SendResponse::fromResponseBody($invalidJson);
    }

    /**
     * @return string[][]
     */
    public static function invalidJsonDataProvider(): array
    {
        return [
            [''],
            ['invalid_json'],
            ['<!DOCTYPE html><html><head></head><body>Oops!</body></html>'],
        ];
    }
}
