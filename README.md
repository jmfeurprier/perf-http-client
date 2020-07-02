HTTP client
===========

Simple HTTP client using cURL internally.

## Installation & Requirements

There are no dependencies on other libraries.

Install with [Composer](http://getcomposer.org):

```shell script
composer require perf/http-client
```

## Usage

### Simple GET request

```php
<?php

use perf\HttpClient\HttpClient;

$httpClient = HttpClient::createDefault();

$request = $httpClient->createRequest();
$request
    ->methodGet()
    ->setUrl('http://localhost/index.html')
;

$response = $httpClient->execute($request);

$httpStatusCode = $response->getHttpStatusCode();
$content        = $response->getBodyContent();

```

### Simple POST request

```php
<?php

use perf\HttpClient\HttpClient;

$httpClient = HttpClient::createDefault();

$request = $httpClient->createRequest();
$request
    ->methodPost(
        [
            'title'   => 'test article',
            'content' => 'article content ...',
            'photo'   => $httpClient->createFile('/path/to/file.jpg')
        ]
    )
    ->setUrl('http://localhost/create-article.php')
;

$response = $httpClient->execute($request);

$httpStatusCode = $response->getHttpStatusCode();
$content        = $response->getBodyContent();

```
