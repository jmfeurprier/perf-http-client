<?php

namespace perf\Http\Client;

/**
 *
 */
class HttpResponseFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testCreateWillReturnExpected()
    {
        $httpStatusCode = 123;
        $headers        = array(
            'foo',
            'bar',
        );
        $bodyContent = 'baz';

        $factory = new HttpResponseFactory();

        $result = $factory->create($httpStatusCode, $headers, $bodyContent);

        $this->assertInstanceOf('\\perf\\Http\\Client\\HttpResponse', $result);
        $this->assertSame($httpStatusCode, $result->getHttpStatusCode());
        $this->assertSame($headers, $result->getHeaders());
        $this->assertSame($bodyContent, $result->getBodyContent());
    }
}
