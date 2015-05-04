<?php

namespace perf\Http\Client;

/**
 *
 *
 */
class HttpClientRequest
{

    /**
     *
     * @var {int:mixed}
     */
    private $options = array(
        \CURLOPT_HEADER         => false,
        \CURLOPT_RETURNTRANSFER => true,
#        \CURLOPT_FOLLOWLOCATION => false,
#        \CURLOPT_FRESH_CONNECT  => false,
#        \CURLOPT_CONNECTTIMEOUT => 5, // Seconds
#        \CURLOPT_TIMEOUT        => 5, // Seconds
#        \CURLOPT_SSL_VERIFYPEER => false,
    );

    /**
     *
     *
     * @param int $timeout
     * @return HttpClientRequest Fluent return.
     */
    public function setConnectTimeout($timeout)
    {
        $timeout = (int) $timeout;

        $this->setOption(\CURLOPT_CONNECTTIMEOUT, $timeout);

        return $this;
    }

    /**
     *
     *
     * @param int $timeout
     * @return HttpClientRequest Fluent return.
     */
    public function setTransferTimeout($timeout)
    {
        $timeout = (int) $timeout;

        $this->setOption(\CURLOPT_TIMEOUT, $timeout);

        return $this;
    }

    /**
     *
     *
     * @return HttpClientRequest Fluent return.
     */
    public function followLocation()
    {
        return $this->setOption(\CURLOPT_FOLLOWLOCATION, true);
    }

    /**
     *
     *
     * @return HttpClientRequest Fluent return.
     */
    public function doNotFollowLocation()
    {
        return $this->setOption(\CURLOPT_FOLLOWLOCATION, false);
    }

    /**
     *
     *
     * @param string $string
     * @return HttpClientRequest Fluent return.
     */
    public function setCookieString($string)
    {
        $this->setOption(\CURLOPT_COOKIE, (string) $string);

        return $this;
    }

    /**
     *
     *
     * @return HttpClientRequest Fluent return.
     */
    public function methodGet()
    {
        $this->setOption(\CURLOPT_HTTPGET, true);

        return $this;
    }

    /**
     *
     *
     * @param {string:mixed} $values
     * @return HttpClientRequest Fluent return.
     */
    public function methodPost(array $values)
    {
        $this->setOption(\CURLOPT_POST, true);
        $this->setOption(\CURLOPT_POSTFIELDS, $values);

        return $this;
    }

    /**
     *
     *
     * @param string $url
     * @return HttpClientRequest Fluent return.
     */
    public function setUrl($url)
    {
        $this->setOption(\CURLOPT_URL, (string) $url);

        return $this;
    }

    /**
     *
     *
     * @param int $option
     * @param mixed $value
     * @return HttpClientRequest Fluent return.
     */
    public function setOption($option, $value)
    {
        $this->options[(int) $option] = $value;

        return $this;
    }

    /**
     *
     *
     * @return {int:mixed}
     */
    public function getOptions()
    {
        return $this->options;
    }
}
