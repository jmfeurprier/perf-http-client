<?php

namespace perf\Http\Client;

/**
 *
 *
 */
class HttpRequest
{

    /**
     *
     *
     * @var {int:mixed}
     */
    private $options = array(
        \CURLOPT_HEADER => true,
    );

    /**
     *
     *
     * @param string $url
     * @return HttpRequest Fluent return.
     */
    public function setUrl($url)
    {
        $this->setOption(\CURLOPT_URL, (string) $url);

        return $this;
    }

    /**
     *
     *
     * @return HttpRequest Fluent return.
     */
    public function methodGet()
    {
        $this->unsetOption(\CURLOPT_CUSTOMREQUEST);
        $this->unsetOption(\CURLOPT_POST);
        $this->unsetOption(\CURLOPT_POSTFIELDS);

        $this->setOption(\CURLOPT_HTTPGET, true);

        return $this;
    }

    /**
     *
     *
     * @param {string:mixed} $values
     * @return HttpRequest Fluent return.
     */
    public function methodPost(array $values)
    {
        $this->unsetOption(\CURLOPT_CUSTOMREQUEST);
        $this->unsetOption(\CURLOPT_HTTPGET);

        $this->setOption(\CURLOPT_POST, true);
        $this->setOption(\CURLOPT_POSTFIELDS, http_build_query($values));

        return $this;
    }

    /**
     *
     *
     * @param {string:mixed} $values
     * @return HttpRequest Fluent return.
     */
    public function methodPut(array $values)
    {
        $this->unsetOption(\CURLOPT_HTTPGET);
        $this->unsetOption(\CURLOPT_POST);

        $this->setOption(\CURLOPT_CUSTOMREQUEST, 'PUT');
        $this->setOption(\CURLOPT_POSTFIELDS, http_build_query($values));

        return $this;
    }

    /**
     *
     *
     * @return HttpRequest Fluent return.
     */
    public function methodDelete()
    {
        $this->unsetOption(\CURLOPT_HTTPGET);
        $this->unsetOption(\CURLOPT_POST);
        $this->unsetOption(\CURLOPT_POSTFIELDS);

        $this->setOption(\CURLOPT_CUSTOMREQUEST, 'DELETE');

        return $this;
    }

    /**
     *
     *
     * @param string $method
     * @param {string:mixed} $values
     * @return HttpRequest Fluent return.
     */
    public function methodCustom($method, array $values = array())
    {
        $this->unsetOption(\CURLOPT_HTTPGET);
        $this->unsetOption(\CURLOPT_POST);

        $this->setOption(\CURLOPT_CUSTOMREQUEST, $method);

        if (count($values) > 0) {
            $this->setOption(\CURLOPT_POSTFIELDS, http_build_query($values));
        } else {
            $this->unsetOption(\CURLOPT_POSTFIELDS);
        }

        return $this;
    }

    /**
     *
     *
     * @param int $timeout
     * @return HttpRequest Fluent return.
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
     * @return HttpRequest Fluent return.
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
     * @return HttpRequest Fluent return.
     */
    public function followLocation()
    {
        return $this->setOption(\CURLOPT_FOLLOWLOCATION, true);
    }

    /**
     *
     *
     * @return HttpRequest Fluent return.
     */
    public function doNotFollowLocation()
    {
        return $this->setOption(\CURLOPT_FOLLOWLOCATION, false);
    }

    /**
     *
     *
     * @param string[] $headers
     * @return HttpRequest Fluent return.
     */
    public function setHeaders(array $headers)
    {
        return $this->setOption(\CURLOPT_HTTPHEADER, $headers);
    }

    /**
     *
     *
     * @param string $string
     * @return HttpRequest Fluent return.
     */
    public function setCookieString($string)
    {
        $this->setOption(\CURLOPT_COOKIE, (string) $string);

        return $this;
    }

    /**
     *
     *
     * @param int $option
     * @param mixed $value
     * @return HttpRequest Fluent return.
     */
    public function setOption($option, $value)
    {
        $this->options[(int) $option] = $value;

        return $this;
    }

    /**
     *
     *
     * @param int $option
     * @return HttpRequest Fluent return.
     */
    private function unsetOption($option)
    {
        unset($this->options[(int) $option]);

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
