<?php

namespace perf\Http\Client;

/**
 *
 */
class HttpClientRequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public static function setUpBeforeClass()
    {
        if (!defined('CURLOPT_URL')) {
            define('CURLOPT_URL', 'CURLOPT_URL');
        }
    }

    /**
     *
     */
    public function testGetOptionsWillReturnArray()
    {
        $request = new HttpClientRequest();

        $result = $request->getOptions();

        $this->assertInternalType('array', $result);
    }

    /**
     *
     */
    public function testGetOptionsWithOptionSetThroughSetOptionWillReturnOptionValue()
    {
        $option = 123;
        $value  = 'bar';

        $request = new HttpClientRequest();

        $request->setOption($option, $value);

        $result = $request->getOptions();

        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey($option, $result);

        $this->assertSame($value, $result[$option]);
    }

    /**
     *
     */
    public function testGetOptionsWillReturnValueFromSetUrl()
    {
        $url = 'foo';

        $request = new HttpClientRequest();

        $request->setUrl($url);

        $result = $request->getOptions();

        $this->assertArrayHasKey(\CURLOPT_URL, $result);
        $this->assertSame($url, $result[\CURLOPT_URL]);
    }
}
