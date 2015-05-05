<?php

namespace perf\Http\Client;

/**
 *
 *
 */
class CurlExecutionResult
{

    /**
     *
     *
     * @var string
     */
    private $responseContent;

    /**
     *
     *
     * @var {string:mixed}
     */
    private $info;

    /**
     * Constructor.
     *
     * @param string $responseContent
     * @param CurlWrapper $curlWrapper
     * @return void
     */
    public function __construct($responseContent, CurlWrapper $curlWrapper)
    {
        $this->responseContent = $responseContent;
        $this->info            = $curlWrapper->getInfo();
    }

    /**
     *
     *
     * @return string
     */
    public function getResponseContent()
    {
        return $this->responseContent;
    }

    /**
     * Get information regarding a specific transfer.
     *
     * @param string $option The key of the option to get
     * @return mixed
     * @throws \DomainException
     */
    public function getInfo($option)
    {
        if (array_key_exists($option, $this->info)) {
            return $this->info[$option];
        }

        throw new \DomainException("Option {$option} not found.");
    }
}
