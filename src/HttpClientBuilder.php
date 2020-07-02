<?php

namespace perf\HttpClient;

use perf\CurlClient\CurlClient;

class HttpClientBuilder
{
    private ?HttpRequestFactory $requestFactory;

    private ?HttpResponseFactory $responseFactory;

    private ?CurlClient $curlClient;

    public function setRequestFactory(HttpRequestFactory $factory): self
    {
        $this->requestFactory = $factory;

        return $this;
    }

    public function setResponseFactory(HttpResponseFactory $factory): self
    {
        $this->responseFactory = $factory;

        return $this;
    }

    public function setCurlClient(CurlClient $client): self
    {
        $this->curlClient = $client;

        return $this;
    }

    public function build(): HttpClient
    {
        return new HttpClient(
            $this->getRequestFactory(),
            $this->getResponseFactory(),
            $this->getCurlClient()
        );
    }

    private function getRequestFactory(): HttpRequestFactory
    {
        return $this->requestFactory ?? new HttpRequestFactory();
    }

    private function getResponseFactory(): HttpResponseFactory
    {
        return $this->responseFactory ?? new HttpResponseFactory();
    }

    private function getCurlClient(): CurlClient
    {
        return $this->curlClient ?? CurlClient::createDefault();
    }
}
