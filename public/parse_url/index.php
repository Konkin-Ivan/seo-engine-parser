<?php

include('utilities/dd.php');

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "172.18.0.1");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

$response = curl_exec($ch);

curl_close($ch);

echo $response;
//dd($fff);