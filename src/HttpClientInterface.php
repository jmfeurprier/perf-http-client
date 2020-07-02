<?php

namespace perf\HttpClient;

use CURLFile;
use perf\HttpClient\Exception\HttpClientException;

interface HttpClientInterface
{
    public function createRequest(): HttpRequest;

    public function createFile(string $filename, string $mimeType = '', string $postFilename = ''): CURLFile;

    /**
     * @param HttpRequest $request
     *
     * @return HttpResponse
     *
     * @throws HttpClientException
     */
    public function execute(HttpRequest $request): HttpResponse;
}