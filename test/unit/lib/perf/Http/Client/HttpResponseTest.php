<?php

namespace perf\Http\Client;

/**
 *
 */
class HttpResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGethttpStatusCodeWillReturnValueProvidedToConstructor()
    {
        $httpStatusCode = 123;
        $headers        = array(
            'foo',
            'bar',
        );
        $bodyContent = 'baz';

        $response = new HttpResponse($httpStatusCode, $headers, $bodyContent);

        $result = $response->gethttpStatusCode();

        $this->assertSame($httpStatusCode, $result);
    }

    /**
     *
     */
    public function testGetUrlWillReturnValueProvidedToConstructor()
    {
        $httpStatusCode = 123;
        $headers        = array(
            'foo',
            'bar',
        );
        $bodyContent = 'baz';

        $response = new HttpResponse($httpStatusCode, $headers, $bodyContent);

        $result = $response->getHeaders();

        $this->assertSame($headers, $result);
    }

    /**
     *
     */
    public function testGetBodyContentWillReturnValueProvidedToConstructor()
    {
        $httpStatusCode = 123;
        $headers        = array(
            'foo',
            'bar',
        );
        $bodyContent = 'baz';

        $response = new HttpResponse($httpStatusCode, $headers, $bodyContent);

        $result = $response->getBodyContent();

        $this->assertSame($bodyContent, $result);
    }
}
