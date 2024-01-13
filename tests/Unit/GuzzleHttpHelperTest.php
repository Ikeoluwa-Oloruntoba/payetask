<?php

namespace Tests\Unit;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use App\Helpers\GuzzleHttpHelper;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpHelperTest extends TestCase
{
    public function testGetSuccess()
    {
        // Arrange
        $guzzleMock = Mockery::mock(Client::class);
        $guzzleHelper = new GuzzleHttpHelper($guzzleMock);

        $url = 'https://dev.to/api/articles';
        $data = ['per_page' => 5];
        $headers = ['Content-Type' => 'application/json'];

        $responseBody = '{"status": "success", "data": "some data"}';
        $mockResponse = new Response(200, [], $responseBody);

        $guzzleMock->shouldReceive('get')
            ->once()
            ->with($url, ['query' => $data, 'headers' => $headers])
            ->andReturn($mockResponse);

        // Act
        $response = $guzzleHelper->get($url, $data, $headers);
        

        // Assert
        $this->assertEquals(['status' => 'success', 'data' => $response['data']], $response);
    }

    public function testGetFailure()
    {
        // Arrange
        $guzzleHelper = new GuzzleHttpHelper($this->guzzleMock);

        $url = 'https://dev.to/api/articles';
        $data = ['per_page' => 5];
        $headers = ['Content-Type' => 'application/json'];

        $exceptionMessage = '{"status": "failed", "data": "error message"}';
        $requestMock = Mockery::mock(RequestInterface::class);
        $responseMock = Mockery::mock(ResponseInterface::class);

        // Mocking the getStatusCode method
        $responseMock->shouldReceive('getStatusCode')->andReturn(500);

        $mockException = new RequestException($exceptionMessage, $requestMock, $responseMock);

        // Mocking the get method
        $this->guzzleMock->shouldReceive('get')
            ->once()
            ->with($url, ['query' => $data, 'headers' => $headers])
            ->andThrow($mockException);

        // Act
        $response = $guzzleHelper->get($url, $data, $headers);

        // Assert
        $this->assertEquals(['status' => 'failed', 'data' => 'error message'], $response);
    }
}

