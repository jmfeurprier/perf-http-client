<?php

namespace perf\HttpClient;

use perf\HttpClient\Exception\HttpClientException;

class HttpRequest
{
    /**
     * @var {int:mixed}
     */
    private array $options = [
        \CURLOPT_HEADER => true,
    ];

    public function setUrl(string $url): self
    {
        $this->setOption(\CURLOPT_URL, $url);

        return $this;
    }

    public function methodGet(): self
    {
        $this->unsetOption(\CURLOPT_CUSTOMREQUEST);
        $this->unsetOption(\CURLOPT_POST);
        $this->unsetOption(\CURLOPT_POSTFIELDS);

        $this->setOption(\CURLOPT_HTTPGET, true);

        return $this;
    }

    public function methodPost(array $values): self
    {
        $this->unsetOption(\CURLOPT_CUSTOMREQUEST);
        $this->unsetOption(\CURLOPT_HTTPGET);

        $this->setOption(\CURLOPT_POST, true);
        $this->setOption(\CURLOPT_POSTFIELDS, $values);

        return $this;
    }

    public function methodPut(array $values): self
    {
        $this->unsetOption(\CURLOPT_HTTPGET);
        $this->unsetOption(\CURLOPT_POST);

        $this->setOption(\CURLOPT_CUSTOMREQUEST, 'PUT');
        $this->setOption(\CURLOPT_POSTFIELDS, http_build_query($values));

        return $this;
    }

    public function methodDelete(array $values = []): self
    {
        $this->unsetOption(\CURLOPT_HTTPGET);
        $this->unsetOption(\CURLOPT_POST);
        $this->unsetOption(\CURLOPT_POSTFIELDS);

        $this->setOption(\CURLOPT_CUSTOMREQUEST, 'DELETE');

        if (!empty($values)) {
            $this->setOption(\CURLOPT_POSTFIELDS, http_build_query($values));
        }

        return $this;
    }

    public function methodCustom(string $method, array $values = []): self
    {
        $this->unsetOption(\CURLOPT_HTTPGET);
        $this->unsetOption(\CURLOPT_POST);
        $this->unsetOption(\CURLOPT_POSTFIELDS);

        $this->setOption(\CURLOPT_CUSTOMREQUEST, $method);

        if (!empty($values)) {
            $this->setOption(\CURLOPT_POSTFIELDS, http_build_query($values));
        }

        return $this;
    }

    /**
     * @param string $path
     *
     * @return HttpRequest
     *
     * @throws HttpClientException
     */
    public function downloadTo(string $path): self
    {
        $fileResource = fopen($path, 'w');

        if (false === $fileResource) {
            throw new HttpClientException('Failed to open destination file for download.');
        }

        $this->setOption(\CURLOPT_FILE, $fileResource);

        return $this;
    }

    public function setConnectTimeout(int $timeout): self
    {
        $this->setOption(\CURLOPT_CONNECTTIMEOUT, $timeout);

        return $this;
    }

    public function setTransferTimeout(int $timeout): self
    {
        $this->setOption(\CURLOPT_TIMEOUT, $timeout);

        return $this;
    }

    public function followLocation(): self
    {
        return $this->setOption(\CURLOPT_FOLLOWLOCATION, true);
    }

    public function doNotFollowLocation(): self
    {
        return $this->setOption(\CURLOPT_FOLLOWLOCATION, false);
    }

    /**
     * @param string[] $headers
     *
     * @return HttpRequest
     */
    public function setHeaders(array $headers): self
    {
        return $this->setOption(\CURLOPT_HTTPHEADER, $headers);
    }

    public function setCookieString(string $string): self
    {
        $this->setOption(\CURLOPT_COOKIE, $string);

        return $this;
    }

    /**
     * @param int   $option
     * @param mixed $value
     *
     * @return HttpRequest
     */
    public function setOption(int $option, $value): self
    {
        $this->options[$option] = $value;

        return $this;
    }

    private function unsetOption(int $option): self
    {
        unset($this->options[(int) $option]);

        return $this;
    }

    /**
     * @return {int:mixed}
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
