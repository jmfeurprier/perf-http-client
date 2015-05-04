<?php

namespace perf\Http;

/**
 *
 */
class HttpClientResponseFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testCreateWillReturnExpected()
    {
        $url        = 'foo';
        $httpStatus = 123;
        $content    = 'bar';

        $factory = new HttpClientResponseFactory();

        $result = $factory->create($url, $httpStatus, $content);

        $this->assertInstanceOf('\\perf\\Http\\HttpClientResponse', $result);
        $this->assertSame($url, $result->getUrl());
        $this->assertSame($httpStatus, $result->getHttpStatus());
        $this->assertSame($content, $result->getContent());
    }
}
