<?php

namespace perf\HttpClient;

use DomainException;

class HttpResponse
{
    private int $httpStatusCode;

    /**
     * @var string[]
     */
    private array $headers;

    private string $bodyContent;

    /**
     * @var {string:mixed}
     */
    private array $transferDetails;

    /**
     * @param int            $httpStatusCode
     * @param string[]       $headers
     * @param string         $bodyContent
     * @param {string:mixed} $transferDetails
     */
    public function __construct(
        int $httpStatusCode,
        array $headers,
        string $bodyContent,
        array $transferDetails = []
    ) {
        $this->httpStatusCode  = $httpStatusCode;
        $this->headers         = $headers;
        $this->bodyContent     = $bodyContent;
        $this->transferDetails = $transferDetails;
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBodyContent(): string
    {
        return $this->bodyContent;
    }

    /**
     * @param string $key
     *
     * @return mixed
     *
     * @throws DomainException
     */
    public function getTransferDetail(string $key)
    {
        if ($this->hasTransferDetail($key)) {
            return $this->transferDetails[$key];
        }

        throw new DomainException("Transfer detail '{$key}' is not defined.");
    }

    public function hasTransferDetail(string $key): bool
    {
        return array_key_exists($key, $this->transferDetails);
    }

    /**
     * @return {string:mixed}
     */
    public function getTransferDetails()
    {
        return $this->transferDetails;
    }
}
