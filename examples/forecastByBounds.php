<?php

include(__DIR__.'/../src/APIClient.php');
include(__DIR__.'/../vendor/autoload.php');


$api = 'https://URLAPI';
$token = 'YOURTOKEN';

$SRClient = new \SportRIZER\Report\ApiClient($api, $token);
$data = $SRClient->getForecastbyBounds(43,-3,45,1,100)->getBody()->getContents();
print_r($data);

