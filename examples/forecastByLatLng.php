<?php

include(__DIR__.'/../src/APIClient.php');
include(__DIR__.'/../vendor/autoload.php');


$api = 'https://URLAPI';
$token = 'YOURTOKEN';

$SRClient = new \SportRIZER\Report\ApiClient($api, $token);
$data = $SRClient->getForecastbyLatLng(47.997542, -4.097899)->getBody()->getContents();
print_r($data);

