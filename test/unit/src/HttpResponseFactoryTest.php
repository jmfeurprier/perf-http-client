<?php

namespace perf\HttpClient;

use PHPUnit\Framework\TestCase;

class HttpResponseFactoryTest extends TestCase
{
    public function testCreateWillReturnExpected()
    {
        $httpStatusCode = 123;
        $headers        = [
            'foo',
            'bar',
        ];
        $bodyContent    = 'baz';

        $factory = new HttpResponseFactory();

        $result = $factory->create($httpStatusCode, $headers, $bodyContent);

        $this->assertInstanceOf(HttpResponse::class, $result);
        $this->assertSame($httpStatusCode, $result->getHttpStatusCode());
        $this->assertSame($headers, $result->getHeaders());
        $this->assertSame($bodyContent, $result->getBodyContent());
    }
}
