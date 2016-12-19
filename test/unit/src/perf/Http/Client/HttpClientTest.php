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
    protected function setUp()
    {
        $this->requestFactory = $this->getMock('\\perf\\Http\\Client\\HttpRequestFactory');

        $this->responseFactory = $this->getMock('\\perf\\Http\\Client\\HttpResponseFactory');

        $this->curlClient = $this->getMockBuilder('\\perf\\Http\\Curl\\CurlClient')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->client = new HttpClient($this->requestFactory, $this->responseFactory, $this->curlClient);
    }

    /**
     *
     */
    public function testCreateRequestWillReturnExpected()
    {
        $request = $this->getMock('\\perf\\Http\\Client\\HttpRequest');

        $this->requestFactory->expects($this->once())->method('create')->willReturn($request);

        $result = $this->client->createRequest();

        $this->assertSame($request, $result);
    }

    /**
     *
     */
    public function testExecute()
    {
        #$content = 'foo';

        $options = array(
            \CURLOPT_URL => 'bar',
        );

        $request = $this->getMock('\\perf\\Http\\Client\\HttpRequest');
        $request->expects($this->atLeastOnce())->method('getOptions')->willReturn($options);

        $expectedOptions = array(
            \CURLOPT_URL            => 'bar',
            \CURLOPT_RETURNTRANSFER => true,
        );

        $transferDetails = array();

        $curlExecutionResult = $this->getMockBuilder('\\perf\\Http\\Curl\\CurlExecutionResult')
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $curlExecutionResult->expects($this->once())->method('getInfos')->willReturn($transferDetails);

        $this->curlClient
            ->expects($this->once())
            ->method('execute')
            ->with($expectedOptions)
            ->willReturn($curlExecutionResult)
        ;

        $response = $this->getMockBuilder('\\perf\\Http\\Client\\HttpResponse')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->responseFactory->expects($this->once())->method('create')->willReturn($response);

        $result = $this->client->execute($request);

        $this->assertSame($response, $result);
    }

    /**
     *
     */
    public function testExecuteWithFailure()
    {
        $options = array(
            CURLOPT_URL => 'bar',
        );
        $error = 'baz';

        $expectedOptions = array(
            \CURLOPT_URL            => 'bar',
            \CURLOPT_RETURNTRANSFER => true,
        );

        $exception = $this->getMockBuilder('\\perf\\Http\\Curl\\CurlExecutionException')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->curlClient
            ->expects($this->once())
            ->method('execute')
            ->with($this->equalTo($expectedOptions))
            ->willThrowException($exception)
        ;

        $request = $this->getMock('\\perf\\Http\\Client\\HttpRequest');
        $request->expects($this->atLeastOnce())->method('getOptions')->willReturn($options);

        $this->setExpectedException('\\RuntimeException');

        $this->client->execute($request);
    }
}
