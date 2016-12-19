<?php

namespace perf\Http\Client;

/**
 *
 */
class HttpRequestFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testCreateWillReturnExpected()
    {
        $factory = new HttpRequestFactory();

        $result = $factory->create();

        $this->assertInstanceOf('\\perf\\Http\\Client\\HttpRequest', $result);
    }
}
