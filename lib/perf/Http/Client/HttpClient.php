<?php

namespace perf\Http\Client;

/**
 *
 *
 */
class HttpClient
{

    /**
     *
     *
     * @var HttpClientRequestFactory
     */
    private $requestFactory;

    /**
     *
     *
     * @var HttpClientResponseFactory
     */
    private $responseFactory;

    /**
     *
     *
     * @var CurlClientFactory
     */
    private $curlClientFactory;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setRequestFactory(new HttpClientRequestFactory());
        $this->setResponseFactory(new HttpClientResponseFactory());
        $this->setCurlClientFactory(new CurlClientFactory());
    }

    /**
     *
     *
     * @param HttpClientRequestFactory $factory
     * @return void
     */
    public function setRequestFactory(HttpClientRequestFactory $factory)
    {
        $this->requestFactory = $factory;
    }

    /**
     *
     *
     * @param HttpClientResponseFactory $factory
     * @return void
     */
    public function setResponseFactory(HttpClientResponseFactory $factory)
    {
        $this->responseFactory = $factory;
    }

    /**
     *
     *
     * @param CurlClientFactory $factory
     * @return void
     */
    public function setCurlClientFactory(CurlClientFactory $factory)
    {
        $this->curlClientFactory = $factory;
    }

    /**
     *
     *
     * @return HttpClientRequest
     */
    public function createRequest()
    {
        return $this->requestFactory->create();
    }

    /**
     *
     *
     * @param HttpClientRequest $request
     * @return HttpClientResponse
     * @throws \RuntimeException
     */
    public function execute(HttpClientRequest $request)
    {
        $curlClient = $this->curlClientFactory->create();

        $curlClient->setOptions($request->getOptions());

        try {
            $content = $curlClient->execute();
        } catch (\RuntimeException $e) {
            $errorMessage = $curlClient->getError();

            throw new \RuntimeException("Failed to execute HTTP request: {$errorMessage}.", 0, $e);
        }

        $httpStatus   = $curlClient->getInfo(\CURLINFO_HTTP_CODE);
        $effectiveUrl = $curlClient->getInfo(\CURLINFO_EFFECTIVE_URL);

        return $this->responseFactory->create($effectiveUrl, $httpStatus, $content);
    }
}
