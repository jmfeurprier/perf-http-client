HTTP client
===========

Simple HTTP client using cURL internally.

## Installation & Requirements

There are no dependencies on other libraries.

Install with [Composer](http://getcomposer.org):

```json
{
	"require":
	{
		"perf-http-client" : "~1.0"
	}
}
```

## Usage

### Simple GET request

```php
<?php

use perf\Http\Client\HttpClient;

$httpClient = HttpClient::createDefault();

$request = $httpClient->createRequest();
$request
    ->methodGet()
    ->setUrl('http://localhost/index.html')
;

$response = $httpClient->execute($request);

$content = $response->getBodyContent();

```
