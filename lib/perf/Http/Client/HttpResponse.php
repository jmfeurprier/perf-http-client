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
    private $headers;

    /**
     *
     *
     * @var string
     */
    private $bodyContent;

    /**
     *
     *
     * @var {string:mixed}
     */
    private $transferDetails;

    /**
     * Constructor.
     *
     * @param int $httpStatusCode
     * @param string[] $headers
     * @param string $bodyContent
     * @param {string:mixed} $transferDetails
     * @return void
     */
    public function __construct($httpStatusCode, array $headers, $bodyContent, array $transferDetails = array())
    {
        $this->httpStatusCode  = $httpStatusCode;
        $this->headers         = $headers;
        $this->bodyContent     = $bodyContent;
        $this->transferDetails = $transferDetails;
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

    /**
     *
     *
     * @param string $key
     * @return bool
     */
    public function hasTransferDetail($key)
    {
        return array_key_exists($key, $this->transferDetails);
    }

    /**
     *
     *
     * @param string $key
     * @return mixed
     * @throws \DomainException
     */
    public function getTransferDetail($key)
    {
        if ($this->hasTransferDetail($key)) {
            return $this->transferDetails[$key];
        }

        throw new \DomainException("Transfer detail '{$key}' is not defined.");
    }
}
