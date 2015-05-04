<?php

namespace perf\Http;

/**
 *
 *
 */
class CurlClient
{

    /**
     * Object-oriented cURL wrapper.
     *
     * @var CurlWrapper
     */
    private $curlWrapper;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setCurlWrapper(new CurlWrapper());
    }

    /**
     *
     *
     * @param CurlWrapper $wrapper
     * @return void
     */
    public function setCurlWrapper(CurlWrapper $wrapper)
    {
        $this->curlWrapper = $wrapper;
    }

    /**
     * Set an option for a cURL transfer.
     *
     * @param int $option The key of the option to set
     * @param mixed $value The value of the option to set
     * @return void
     * @throws \RuntimeException
     */
    public function setOption($option, $value)
    {
        if (!$this->curlWrapper->setOption($option, $value)) {
            throw new \RuntimeException();
        }
    }

    /**
     * Set multiple options for a cURL transfer.
     *
     * @param array $options Array of options
     * @return void
     * @throws \RuntimeException
     */
    public function setOptions(array $options)
    {
        if (!$this->curlWrapper->setOptions($options)) {
            throw new \RuntimeException();
        }
    }

    /**
     * Perform a cURL session.
     *
     * @return string
     * @throws \RuntimeException
     */
    public function execute()
    {
        $result = $this->curlWrapper->execute();

        if (false === $result) {
            throw new \RuntimeException('Failed to execute cURL request.');
        }

        return $result;
    }

    /**
     * Get information regarding a specific transfer.
     *
     * @param int $option The key of the option to get
     * @return mixed
     */
    public function getInfo($option = 0)
    {
        return $this->curlWrapper->getInfo($option);
    }

    /**
     * Return a string containing the last error for the current session.
     *
     * @return string
     */
    public function getError()
    {
        return $this->curlWrapper->getError();
    }

    /**
     * Return the last error number.
     *
     * @return int
     */
    public function getErrorNumber()
    {
        return $this->curlWrapper->getErrorNumber();
    }

    /**
     * Copy a cURL handle along with all of its preferences.
     *
     * @return void
     */
    public function __clone()
    {
        $this->curlWrapper = clone $this->curlWrapper;
    }
}
