<?php

namespace perf\Http;

/**
 *
 *
 */
class HttpClientResponse
{

    /**
     *
     *
     * @var string
     */
    private $url;

    /**
     *
     *
     * @var int
     */
    private $httpStatus;

    /**
     *
     *
     * @var string
     */
    private $content;

    /**
     * Constructor.
     *
     * @param string $url
     * @param int $httpStatus
     * @param string $content
     * @return void
     */
    public function __construct($url, $httpStatus, $content)
    {
        $this->url        = (string) $url;
        $this->httpStatus = (int) $httpStatus;
        $this->content    = (string) $content;
    }

    /**
     *
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     *
     *
     * @return int
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /**
     *
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}
