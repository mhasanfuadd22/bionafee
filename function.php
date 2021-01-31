<?php

function getIP() {
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
    $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
    $ip = $forward;
    }
    else
    {
    $ip = $remote;
    }

    return $ip;
}

function ipInfo($ip) {
    $curl = curl_init();
    $ipserver = array(
        'http://ip-api.com/',
    );
    $n = array_rand($ipserver, 1);
    // echo $ipserver[$n];
    curl_setopt_array($curl, array(
    CURLOPT_URL => $ipserver[$n]."json/".$ip,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "utf8",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "accept: application/json",
        "content-type: application/json"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    //print_r($response);
    curl_close($curl);

    if ($err) {
    return "cURL Error #:" . $err;
    } else {
    return $response;
    }
}