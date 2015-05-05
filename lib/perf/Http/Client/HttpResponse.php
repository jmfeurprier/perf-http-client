<?php

namespace perf\Http\Client;

/**
 *
 *
 */
class HttpResponse
{

    /**
     *
     *
     * @var int
     */
    private $httpStatusCode;

    /**
     *
     *
     * @var string[]
     */
    private $headers = array();

    /**
     *
     *
     * @var string
     */
    private $bodyContent;

    /**
     * Constructor.
     *
     * @param int $httpStatusCode
     * @param string[] $headers
     * @param string $bodyContent
     * @return void
     */
    public function __construct($httpStatusCode, array $headers, $bodyContent)
    {
        $this->httpStatusCode  = $httpStatusCode;
        $this->headers         = $headers;
        $this->bodyContent     = $bodyContent;
    }

    /**
     *
     *
     * @return int
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     *
     *
     * @return string[]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     *
     *
     * @return string
     */
    public function getBodyContent()
    {
        return $this->bodyContent;
    }
}
