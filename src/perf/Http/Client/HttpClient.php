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
     * @param string $filename
     * @param string $mimeType
     * @param string $postFilename
     * @return \CURLFile
     */
    public function createFile($filename, $mimeType = '', $postFilename = '')
    {
        return $this->curlClient->createFile($filename, $mimeType, $postFilename);
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
        $result         = $this->getResult($request);
        $httpStatusCode = $result->getInfo('http_code');
        $options        = $request->getOptions();
        $headers        = array();
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
     *
     *
     * @param HttpRequest $request
     * @return CurlExecutionResult
     * @throws \RuntimeException
     */
    private function getResult(HttpRequest $request)
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
            throw new \RuntimeException("Failed to execute HTTP request. << {$e->getMessage()}", 0, $e);
        }

        return $result;
    }

    /**
     *
     *
     * @param HttpRequest $request
     * @return bool
     */
    private function isDownload(HttpRequest $request)
    {
        $options = $request->getOptions();

        return (array_key_exists(\CURLOPT_FILE, $options) && is_resource($options[\CURLOPT_FILE]));
    }
}
