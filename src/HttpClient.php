<?php

namespace perf\HttpClient;

use CURLFile;
use perf\CurlClient\CurlClient;
use perf\CurlClient\CurlExecutionResult;
use perf\CurlClient\Exception\CurlExecutionException;
use perf\HttpClient\Exception\HttpClientException;

class HttpClient implements HttpClientInterface
{
    private HttpRequestFactory $requestFactory;

    private HttpResponseFactory $responseFactory;

    private CurlClient $curlClient;

    public static function createDefault(): HttpClient
    {
        return self::createBuilder()->build();
    }

    public static function createBuilder(): HttpClientBuilder
    {
        return new HttpClientBuilder();
    }

    public function __construct(
        HttpRequestFactory $requestFactory,
        HttpResponseFactory $responseFactory,
        CurlClient $curlClient
    ) {
        $this->requestFactory  = $requestFactory;
        $this->responseFactory = $responseFactory;
        $this->curlClient      = $curlClient;
    }

    public function createRequest(): HttpRequest
    {
        return $this->requestFactory->create();
    }

    public function createFile(string $filename, string $mimeType = '', string $postFilename = ''): CURLFile
    {
        return $this->curlClient->createFile($filename, $mimeType, $postFilename);
    }

    /**
     * @param HttpRequest $request
     *
     * @return HttpResponse
     *
     * @throws HttpClientException
     */
    public function execute(HttpRequest $request): HttpResponse
    {
        $result         = $this->getResult($request);
        $httpStatusCode = $result->getInfo('http_code');
        $options        = $request->getOptions();
        $headers        = [];
        $bodyContent    = '';

        if (!$this->isDownload($request)) {
            $withHeader = (array_key_exists(\CURLOPT_HEADER, $options) && $options[\CURLOPT_HEADER]);
            $withBody   = !(array_key_exists(\CURLOPT_NOBODY, $options) && $options[\CURLOPT_NOBODY]);

            if ($withHeader && $withBody) {
                $responseContent = $result->getResponseContent();
                $position        = $result->getInfo('header_size');
                $headerContent   = substr($responseContent, 0, $position);
                $headers         = preg_split('|\\r\\n|', $headerContent, -1, \PREG_SPLIT_NO_EMPTY);
                $bodyContent     = substr($responseContent, $position);
            } elseif ($withHeader) {
                $headerContent = $result->getResponseContent();
                $headers       = explode("\r\n", $headerContent);
            } elseif ($withBody) {
                $bodyContent = $result->getResponseContent();
            }
        }

        return $this->responseFactory->create($httpStatusCode, $headers, $bodyContent, $result->getInfos());
    }

    /**
     * @param HttpRequest $request
     *
     * @return CurlExecutionResult
     *
     * @throws HttpClientException
     */
    private function getResult(HttpRequest $request): CurlExecutionResult
    {
        $options = $request->getOptions();

        if ($this->isDownload($request)) {
            $options[\CURLOPT_HEADER] = false;
            $options[\CURLOPT_NOBODY] = false;
        } else {
            $options[\CURLOPT_RETURNTRANSFER] = true;
        }
    
        try {
            $result = $this->curlClient->execute($options);
        } catch (CurlExecutionException $e) {
            throw new HttpClientException("Failed to execute HTTP request. << {$e->getMessage()}", 0, $e);
        }

        return $result;
    }

    private function isDownload(HttpRequest $request): bool
    {
        $options = $request->getOptions();

        return (array_key_exists(\CURLOPT_FILE, $options) && is_resource($options[\CURLOPT_FILE]));
    }
}
