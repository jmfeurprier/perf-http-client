<?php

namespace perf\Http\Client;

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
     * @return HttpBuilder Fluent return.
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
     * @return HttpBuilder Fluent return.
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
     * @return HttpBuilder Fluent return.
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
            $curlWrapperFactory = new CurlWrapperFactory();

            $curlExecuter = new CurlExecuter($curlWrapperFactory);
        }

        return new HttpClient($requestFactory, $responseFactory, $curlExecuter);
    }
}
