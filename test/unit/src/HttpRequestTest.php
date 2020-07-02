<?php

namespace perf\HttpClient;

use PHPUnit\Framework\TestCase;

class HttpRequestTest extends TestCase
{
    public function testGetOptionsWillReturnArray()
    {
        $request = new HttpRequest();

        $result = $request->getOptions();

        $this->assertIsArray($result);
    }

    public function testGetOptionsWithOptionSetThroughSetOptionWillReturnOptionValue()
    {
        $option = 123;
        $value  = 'bar';

        $request = new HttpRequest();

        $request->setOption($option, $value);

        $result = $request->getOptions();

        $this->assertIsArray($result);
        $this->assertArrayHasKey($option, $result);

        $this->assertSame($value, $result[$option]);
    }

    public function testGetOptionsWillReturnValueFromSetUrl()
    {
        $url = 'foo';

        $request = new HttpRequest();

        $request->setUrl($url);

        $result = $request->getOptions();

        $this->assertArrayHasKey(\CURLOPT_URL, $result);
        $this->assertSame($url, $result[\CURLOPT_URL]);
    }
}
