<?php

namespace perf\Http;

/**
 * Object-oriented wrapper for PHP cURL functions.
 *
 */
class CurlWrapper
{

    /**
     * cURL resource.
     *
     * @var resource
     */
    private $curl;

    /**
     * Constructor.
     * Wrapper for PHP function curl_init().
     *
     * @param null|string $url
     * @return void
     */
    public function __construct($url = null)
    {
        $this->curl = curl_init($url);
    }

    /**
     * Copy a cURL handle along with all of its preferences.
     * Wrapper for PHP function curl_copy_handle().
     *
     * @return void
     */
    public function __clone()
    {
        $this->curl = curl_copy_handle($this->curl);
    }

    /**
     * Destructor.
     * Wrapper for PHP function curl_close().
     *
     * @return void
     */
    public function __destruct()
    {
        curl_close($this->curl);
    }

    /**
     * Set an option for a cURL transfer.
     * Wrapper for PHP function curl_setopt().
     *
     * @param int $option The key of the option to set
     * @param mixed $value The value of the option to set
     * @return bool
     */
    public function setOption($option, $value)
    {
        return curl_setopt($this->curl, $option, $value);
    }

    /**
     * Set multiple options for a cURL transfer.
     * Wrapper for PHP function curl_setopt_array().
     *
     * @param array $options Array of options
     * @return bool
     */
    public function setOptions(array $options)
    {
        return curl_setopt_array($this->curl, $options);
    }

    /**
     * Perform a cURL session.
     * Wrapper for PHP function curl_exec().
     *
     * @return bool|string
     */
    public function execute()
    {
        return curl_exec($this->curl);
    }

    /**
     * Get information regarding a specific transfer.
     * Wrapper for PHP function curl_getinfo()
     *
     * @param int $option The key of the option to get
     * @return mixed
     */
    public function getInfo($option = 0)
    {
        return curl_getinfo($this->curl, $option);
    }

    /**
     * Return a string containing the last error for the current session.
     * Wrapper for PHP function curl_error().
     *
     * @return string
     */
    public function getError()
    {
        return curl_error($this->curl);
    }

    /**
     * Return the last error number.
     * Wrapper for PHP function curl_errno().
     *
     * @return int
     */
    public function getErrorNumber()
    {
        return curl_errno($this->curl);
    }

    /**
     * Return cURL current version information.
     * Wrapper for PHP function curl_version().
     *
     * @return {string:mixed}
     */
    public function getVersion($age = \CURLVERSION_NOW)
    {
        return curl_version($age);
    }
}
