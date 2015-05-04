<?php

namespace perf\Http;

/**
 *
 *
 */
class CurlClientFactory
{

    /**
     * Returns a new cURL client.
     *
     * @return CurlClient
     */
    public function create()
    {
        return new CurlClient();
    }
}
