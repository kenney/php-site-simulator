<?php

$codes = array
(
  200, 301, 404, 500
);


$msg = "";

$bad_site = false;
if (file_exists("/tmp/badsite")) {
  $bad_site = true;
  $msg .= "BAD SITE\t";
} else {
  $msg .= "GOOD SITE\t";
}

if ($bad_site) {
  $base_200 = 300;
  $base_300 = 400;
  $base_400 = 600;
} else {
  $base_200 = 850;
  $base_300 = 950;
  $base_400 = 975;
}

$rand = rand(0, 1000);

switch ($rand) {

  case ($rand < $base_200):
    $code = 200;
    header("HTTP/1.0 200 Ok");
    echo "Hello World!";
    break;
  case ($rand < $base_300):
    $code = 301;
    header("Location: /foobar", TRUE, 301);
    break;
  case ($rand < $base_400):
    $code = 404;
    header("HTTP/1.0 404 Not Found");
    break;
  default:
    $code = 500;
    header("HTTP/1.0 500 Internal Server Error");
}


$msg .= "Code $code\t";

if ($code != 200 || $bad_site) {
  header( 'Cache-Control: no-store, no-cache, must-revalidate' );
  header( 'Cache-Control: post-check=0, pre-check=0', false );
  header( 'Pragma: no-cache' );
  header("Cache-Control: maxage=0");
  $expires = 0;
} else {
  $cache_lucky = rand(0,100);
  if ($cache_lucky > 10 && !$bad_site) {
    $expires = rand(0,60);
    header("Cache-Control: max-age=".$expires);
  } elseif ($cache_lucky > 20) {
    $expires = rand(0, 5);
    header("Cache-Control: max-age=".$expires);
  } else {
    $expires = 0;
    header( 'Cache-Control: no-store, no-cache, must-revalidate' );
    header( 'Cache-Control: post-check=0, pre-check=0', false );
    header( 'Pragma: no-cache' );
  }
}

$msg .= "Expires $expires\t";
error_log($msg);