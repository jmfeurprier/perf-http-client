<?php

namespace perf\Http\Client;

/**
 *
 *
 */
class CurlExecuter
{

    /**
     *
     *
     * @var CurlWrapperFactory
     */
    private $curlWrapperFactory;

    /**
     *
     *
     * @param CurlWrapperFactory $curlWrapperFactory
     * @return void
     */
    public function __construct(CurlWrapperFactory $curlWrapperFactory)
    {
        $this->curlWrapperFactory = $curlWrapperFactory;
    }

    /**
     *
     *
     * @param {int:mixed} $options
     * @return CurlExecutionResult
     * @throws CurlExecutionException
     */
    public function execute(array $options)
    {
        $curlWrapper = $this->curlWrapperFactory->create();

        if (!$curlWrapper->setOptions($options)) {
            throw new CurlExecutionException($curlWrapper);
        }

        $responseContent = $curlWrapper->execute();

        if (false === $responseContent) {
            throw new CurlExecutionException($curlWrapper);
        }

        return new CurlExecutionResult($responseContent, $curlWrapper);
    }
}
