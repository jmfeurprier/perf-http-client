<?php

namespace perf\Http\Client;

/**
 *
 */
class HttpClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testCreateRequestWillReturnExpected()
    {
        $request = $this->getMock('\\perf\\Http\\Client\\HttpClientRequest');

        $requestFactory = $this->getMock('\\perf\\Http\\Client\\HttpClientRequestFactory');
        $requestFactory->expects($this->once())->method('create')->will($this->returnValue($request));

        $client = new HttpClient();
        $client->setRequestFactory($requestFactory);

        $result = $client->createRequest();

        $this->assertSame($request, $result);
    }

    /**
     *
     */
    public function testExecute()
    {
        $content = 'foo';

        $options = array(
            CURLOPT_URL => 'bar',
        );

        $curlClient = $this->getMock('\\perf\\Http\\Client\\CurlClient');
        $curlClient->expects($this->at(0))->method('setOptions')->with($this->equalTo($options));
        $curlClient->expects($this->at(1))->method('execute')->will($this->returnValue($content));

        $curlClientFactory = $this->getMock('\\perf\\Http\\Client\\CurlClientFactory');
        $curlClientFactory->expects($this->once())->method('create')->will($this->returnValue($curlClient));

        $request = $this->getMock('\\perf\\Http\\Client\\HttpClientRequest');
        $request->expects($this->once())->method('getOptions')->will($this->returnValue($options));

        $response = $this->getMockBuilder('\\perf\\Http\\Client\\HttpClientResponse')->disableOriginalConstructor()->getMock();

        $responseFactory = $this->getMock('\\perf\\Http\\Client\\HttpClientResponseFactory');
        $responseFactory->expects($this->once())->method('create')->with($this->anything(), $this->anything(), $content)->will($this->returnValue($response));

        $client = new HttpClient();
        $client->setCurlClientFactory($curlClientFactory);
        $client->setResponseFactory($responseFactory);

        $result = $client->execute($request);

        $this->assertSame($response, $result);
    }

    /**
     *
     */
    public function testExecuteWithFailure()
    {
        $content = 'foo';
        $options = array(
            CURLOPT_URL => 'bar',
        );
        $error = 'baz';

        $exception = new \RuntimeException('');

        $curlClient = $this->getMock('\\perf\\Http\\Client\\CurlClient');
        $curlClient->expects($this->at(0))->method('setOptions')->with($this->equalTo($options));
        $curlClient->expects($this->at(1))->method('execute')->will($this->throwException($exception));
        $curlClient->expects($this->at(2))->method('getError')->will($this->returnValue($error));

        $curlClientFactory = $this->getMock('\\perf\\Http\\Client\\CurlClientFactory');
        $curlClientFactory->expects($this->once())->method('create')->will($this->returnValue($curlClient));

        $request = $this->getMock('\\perf\\Http\\Client\\HttpClientRequest');
        $request->expects($this->once())->method('getOptions')->will($this->returnValue($options));

        $client = new HttpClient();
        $client->setCurlClientFactory($curlClientFactory);

        $this->setExpectedException('\\RuntimeException', "Failed to execute HTTP request: {$error}.");

        $client->execute($request);
    }
}
