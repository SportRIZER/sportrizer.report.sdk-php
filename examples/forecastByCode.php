<?php

include(__DIR__.'/../vendor/autoload.php');

use Sportrizer\Report\ApiClient;

$api = 'https://URLAPI';
$token = 'YOURTOKEN';

$SRClient = new ApiClient($api, $token);
$data = $SRClient->getForecastByCode(29232)->getBody()->getContents();
print_r($data);

