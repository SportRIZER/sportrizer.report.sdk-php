<?php

include(__DIR__.'/../vendor/autoload.php');

use Sportrizer\Report\ApiClient;

$api = 'https://URLAPI';
$token = 'YOURTOKEN';

$SRClient = new ApiClient($api, $token);
$data = $SRClient->getForecastbyLatLng(47.997542, -4.097899)->getBody()->getContents();
print_r($data);

