<?php

namespace perf\Http\Client;

use perf\Http\Curl\CurlClient;

/**
 *
 *
 */
class HttpClientBuilder
{

    /**
     *
     *
     * @var HttpRequestFactory
     */
    private $requestFactory;

    /**
     *
     *
     * @var HttpResponseFactory
     */
    private $responseFactory;

    /**
     *
     *
     * @var CurlClient
     */
    private $curlClient;

    /**
     *
     *
     * @param HttpRequestFactory $factory
     * @return HttpClientBuilder Fluent return.
     */
    public function setRequestFactory(HttpRequestFactory $factory)
    {
        $this->requestFactory = $factory;

        return $this;
    }

    /**
     *
     *
     * @param HttpResponseFactory $factory
     * @return HttpClientBuilder Fluent return.
     */
    public function setResponseFactory(HttpResponseFactory $factory)
    {
        $this->responseFactory = $factory;

        return $this;
    }

    /**
     *
     *
     * @param CurlClient $client
     * @return HttpClientBuilder Fluent return.
     */
    public function setCurlClient(CurlClient $client)
    {
        $this->curlClient = $client;

        return $this;
    }

    /**
     *
     *
     * @return HttpClient
     */
    public function build()
    {
        if ($this->requestFactory) {
            $requestFactory = $this->requestFactory;
        } else {
            $requestFactory = new HttpRequestFactory();
        }

        if ($this->responseFactory) {
            $responseFactory = $this->responseFactory;
        } else {
            $responseFactory = new HttpResponseFactory();
        }

        if ($this->curlClient) {
            $curlClient = $this->curlClient;
        } else {
            $curlClient = CurlClient::createDefault();
        }

        return new HttpClient($requestFactory, $responseFactory, $curlClient);
    }
}
