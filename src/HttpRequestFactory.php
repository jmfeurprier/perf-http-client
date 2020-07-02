<?php

namespace perf\HttpClient;

class HttpRequestFactory
{
    public function create(): HttpRequest
    {
        return new HttpRequest();
    }
}
