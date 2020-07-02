<?php

namespace perf\HttpClient;

use perf\CurlClient\CurlClient;
use perf\CurlClient\CurlExecutionResult;
use perf\CurlClient\Exception\CurlExecutionException;
use perf\HttpClient\Exception\HttpClientException;
use PHPUnit\Framework\TestCase;

class HttpClientTest extends TestCase
{
    private $requestFactory;
    private $responseFactory;
    private $curlClient;

    private HttpClient $client;

    protected function setUp(): void
    {
        $this->requestFactory = $this->createMock(HttpRequestFactory::class);

        $this->responseFactory = $this->createMock(HttpResponseFactory::class);

        $this->curlClient = $this->createMock(CurlClient::class);

        $this->client = new HttpClient(
            $this->requestFactory,
            $this->responseFactory,
            $this->curlClient
        );
    }

    public function testCreateRequestWillReturnExpected()
    {
        $request = $this->createMock(HttpRequest::class);

        $this->requestFactory->expects($this->once())->method('create')->willReturn($request);

        $result = $this->client->createRequest();

        $this->assertSame($request, $result);
    }

    public function testExecute()
    {
        $options = [
            \CURLOPT_URL => 'bar',
        ];

        $request = $this->createMock(HttpRequest::class);
        $request->expects($this->atLeastOnce())->method('getOptions')->willReturn($options);

        $expectedOptions = [
            \CURLOPT_URL            => 'bar',
            \CURLOPT_RETURNTRANSFER => true,
        ];

        $transferDetails = [];

        $curlExecutionResult = $this->createMock(CurlExecutionResult::class);
        $curlExecutionResult->expects($this->once())->method('getInfos')->willReturn($transferDetails);
        $curlExecutionResult->expects($this->once())->method('getInfo')->willReturn(200);
        $curlExecutionResult->expects($this->once())->method('getResponseContent')->willReturn('');

        $this->curlClient
            ->expects($this->once())
            ->method('execute')
            ->with($expectedOptions)
            ->willReturn($curlExecutionResult);

        $response = $this->createMock(HttpResponse::class);

        $this->responseFactory->expects($this->once())->method('create')->willReturn($response);

        $result = $this->client->execute($request);

        $this->assertSame($response, $result);
    }

    public function testExecuteWithFailure()
    {
        $options = [
            \CURLOPT_URL => 'bar',
        ];
        $error   = 'baz';

        $expectedOptions = [
            \CURLOPT_URL            => 'bar',
            \CURLOPT_RETURNTRANSFER => true,
        ];

        $exception = $this->createMock(CurlExecutionException::class);

        $this->curlClient
            ->expects($this->once())
            ->method('execute')
            ->with($this->equalTo($expectedOptions))
            ->willThrowException($exception);

        $request = $this->createMock(HttpRequest::class);
        $request->expects($this->atLeastOnce())->method('getOptions')->willReturn($options);

        $this->expectException(HttpClientException::class);

        $this->client->execute($request);
    }
}
