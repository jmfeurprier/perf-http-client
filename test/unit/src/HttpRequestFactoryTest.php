<?php

namespace perf\HttpClient;

use PHPUnit\Framework\TestCase;

class HttpRequestFactoryTest extends TestCase
{
    public function testCreateWillReturnExpected()
    {
        $factory = new HttpRequestFactory();

        $result = $factory->create();

        $this->assertInstanceOf(HttpRequest::class, $result);
    }
}
