<?php
$url = "https://staging-gtw.seraphin.be/quotes/professional-liability";
$APIkey = 'fABF1NGkfn5fpHuJHrbvG3niQX6A1CO53ftF9ASD';

$curl = curl_init($url);

$headers = [
    'X-Api-Key' => $APIkey,
    'Content-Type:' => 'application/json',
];
$payload = [
    'annualRevenue' => 80000,
    'enterpriseNumber' => '0649885171',
    'legalName' => 'example SA',
    'naturalPerson' => true,
    'nacebelCodes' => ['62010', '62020', '62030', '62090', '63110'],
];


curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);
