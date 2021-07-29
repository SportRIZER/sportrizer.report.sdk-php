<?php

include(__DIR__.'/../vendor/autoload.php');

use Sportrizer\Report\ApiClient;

$api = 'https://URLAPI';
$token = 'YOURTOKEN';

$SRClient = new ApiClient($api, $token);
$data = $SRClient->getForecastbyBounds(43,-3,45,1,100)->getBody()->getContents();
print_r($data);

