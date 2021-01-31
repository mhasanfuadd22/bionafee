<?php

include("config.php");
include("function.php");

$ip = getIP();
$ipinfo = ipInfo($ip);
$info = json_decode($ipinfo, true);

if ( array_key_exists( $info['countryCode'], $linkOffer ) ) {
    header("HTTP/1.1 301 Moved Permanently"); 
    header("Location: " . $linkOffer[$info['countryCode']]); 
    exit();
} else {
    header("HTTP/1.1 301 Moved Permanently"); 
    header("Location: " . $linkOffer['ALL']); 
    exit();
}