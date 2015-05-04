<?php

namespace perf\Http\Client;

/**
 *
 */
class HttpClientResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetUrlWillReturnValueProvidedToConstructor()
    {
        $url        = 'foo';
        $httpStatus = 123;
        $content    = 'bar';

        $response = new HttpClientResponse($url, $httpStatus, $content);

        $result = $response->getUrl();

        $this->assertSame($url, $result);
    }

    /**
     *
     */
    public function testGetHttpStatusWillReturnValueProvidedToConstructor()
    {
        $url        = 'foo';
        $httpStatus = 123;
        $content    = 'bar';

        $response = new HttpClientResponse($url, $httpStatus, $content);

        $result = $response->getHttpStatus();

        $this->assertSame($httpStatus, $result);
    }

    /**
     *
     */
    public function testGetContentWillReturnValueProvidedToConstructor()
    {
        $url        = 'foo';
        $httpStatus = 123;
        $content    = 'bar';

        $response = new HttpClientResponse($url, $httpStatus, $content);

        $result = $response->getContent();

        $this->assertSame($content, $result);
    }
}
