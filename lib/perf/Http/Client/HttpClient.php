<?php

namespace perf\Http\Client;

use perf\Http\Curl\CurlClient;
use perf\Http\Curl\CurlExecutionException;
use perf\Http\Curl\CurlExecutionResult;

/**
 *
 *
 */
class HttpClient
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
     * @return HttpClient
     */
    public static function createDefault()
    {
        return self::createBuilder()->build();
    }

    /**
     *
     *
     * @return HttpClientBuilder
     */
    public static function createBuilder()
    {
        return new HttpClientBuilder();
    }

    /**
     * Constructor.
     *
     * @param HttpRequestFactory $requestFactory
     * @param HttpResponseFactory $responseFactory
     * @param CurlClient $curlClient
     * @return void
     */
    public function __construct(
        HttpRequestFactory $requestFactory,
        HttpResponseFactory $responseFactory,
        CurlClient $curlClient
    ) {
        $this->requestFactory  = $requestFactory;
        $this->responseFactory = $responseFactory;
        $this->curlClient      = $curlClient;
    }

    /**
     *
     *
     * @return HttpRequest
     */
    public function createRequest()
    {
        return $this->requestFactory->create();
    }

    /**
     *
     *
     * @param HttpRequest $request
     * @return HttpResponse
     * @throws \RuntimeException
     */
    public function execute(HttpRequest $request)
    {
        $result = $this->getResult($request);

        $httpStatus = $result->getInfo('http_code');

        $options    = $request->getOptions();
        $withHeader = (array_key_exists(\CURLOPT_HEADER, $options) && $options[\CURLOPT_HEADER]);
        $withBody   = !(array_key_exists(\CURLOPT_NOBODY, $options) && $options[\CURLOPT_NOBODY]);

        $headers     = array();
        $bodyContent = '';

        if ($withHeader && $withBody) {
            $responseContent = $result->getResponseContent();
            $position = strpos($responseContent, "\r\n\r\n", 0);
            
            if (false === $position) {
                throw new \RuntimeException();
            }
            
            $headerContent = substr($responseContent, 0, $position);
            $headers       = explode("\r\n", $headerContent);
            $bodyContent   = substr($responseContent, $position + 4);
        } elseif ($withHeader) {
            $headerContent = $result->getResponseContent();
            $headers       = explode("\r\n", $headerContent);
        } elseif ($withBody) {
            $bodyContent = $result->getResponseContent();
        }

        return $this->responseFactory->create($httpStatus, $headers, $bodyContent);
    }

    /**
     *
     *
     * @param HttpRequest $request
     * @return CurlExecutionResult
     * @throws \RuntimeException
     */
    private function getResult(HttpRequest $request)
    {
        $options = $request->getOptions();
        $options[\CURLOPT_RETURNTRANSFER] = true;
    
        try {
            $result = $this->curlClient->execute($options);
        } catch (CurlExecutionException $e) {
            throw new \RuntimeException("Failed to execute HTTP request. << {$e->getMessage()}", 0, $e);
        }

        return $result;
    }
}
