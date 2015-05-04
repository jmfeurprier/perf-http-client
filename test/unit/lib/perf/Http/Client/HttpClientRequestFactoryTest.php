<?php

namespace perf\Http\Client;

/**
 *
 */
class HttpClientRequestFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testCreateWillReturnExpected()
    {
        $factory = new HttpClientRequestFactory();

        $result = $factory->create();

        $this->assertInstanceOf('\\perf\\Http\\HttpClientRequest', $result);
    }
}