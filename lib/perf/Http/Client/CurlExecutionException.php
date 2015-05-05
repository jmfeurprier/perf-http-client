<?php

namespace perf\Http\Client;

/**
 *
 *
 */
class CurlExecutionException extends \RuntimeException
{

    /**
     *
     *
     * @var {string:mixed}
     */
    private $info;

    /**
     * Constructor.
     *
     * @param CurlWrapper $curlWrapper
     * @return void
     */
    public function __construct(CurlWrapper $curlWrapper)
    {
        parent::__construct($curlWrapper->getError(), $curlWrapper->getErrorNumber());

        $this->info = $curlWrapper->getInfo();
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
