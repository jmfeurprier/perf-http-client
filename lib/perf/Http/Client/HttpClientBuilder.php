<?php

namespace perf\Http\Client;

use perf\Http\Curl\CurlExecuter;

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
     * @var CurlExecuter
     */
    private $curlExecuter;

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
     * @param CurlExecuter $curlExecuter
     * @return HttpClientBuilder Fluent return.
     */
    public function setCurlExecuter(CurlExecuter $executer)
    {
        $this->curlExecuter = $executer;

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

        if ($this->curlExecuter) {
            $curlExecuter = $this->curlExecuter;
        } else {
            $curlExecuter = CurlExecuter::createDefault();
        }

        return new HttpClient($requestFactory, $responseFactory, $curlExecuter);
    }
}
