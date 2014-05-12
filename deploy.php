#!/usr/bin/php
<?php

/*
 * Deploy.php is used to trigger/simulate a bad or good deployment.
 * It (for now) touches a file in /tmp that says it was bad.
 */

$fake_site_key = "site.www_domain_com.deploys";
$fake_graphite_server = "graphite.acme.org"

if ($argc == 1) {
  echo Escape_Colors::fg_color('yellow', 'Pass good or bad') . "\n";
  exit;
}

$which = $argv[1];
$valid_which = array("good", "bad");
if (!in_array($which, $valid_which)) {
   echo Escape_Colors::fg_color('yellow', 'We do not understand ' . $which) . "\n";
  exit; 
}

$badfile = "/tmp/badsite";

if ($which == 'good') {
  echo Escape_Colors::fg_color('green', 'GOOD DEVELOPER') . " You committed working code!!!\n";
  if (file_exists($badfile)) {
    unlink($badfile);
  }
} else {
  echo Escape_Colors::fg_color('red', 'BAD DEVELOPER!!!') . " Did you not check " .
    Escape_Colors::fg_color('bold_purple', 'INSIGHT') . " before deploying?!\n";
  touch($badfile);
}

exec("echo '$fake_site_key:1|c' | nc -uw1 $fake_graphite_server 8125");

/**
 * Color escapes for bash output
 */
class Escape_Colors
{
 private static $foreground = array(
  'black' => '0;30',
  'dark_gray' => '1;30',
  'red' => '0;31',
  'bold_red' => '1;31',
  'green' => '0;32',
  'bold_green' => '1;32',
  'brown' => '0;33',
  'yellow' => '1;33',
  'blue' => '0;34',
  'bold_blue' => '1;34',
  'purple' => '0;35',
  'bold_purple' => '1;35',
  'cyan' => '0;36',
  'bold_cyan' => '1;36',
  'white' => '1;37',
  'bold_gray' => '0;37',
 );
 
 private static $background = array(
  'black' => '40',
  'red' => '41',
  'magenta' => '45',
  'yellow' => '43',
  'green' => '42',
  'blue' => '44',
  'cyan' => '46',
  'light_gray' => '47',
 );
 
 /**
  * Make string appear in color
  */
 public static function fg_color($color, $string)
 {
  if (!isset(self::$foreground[$color]))
  {
   throw new Exception('Foreground color is not defined');
  }
 
  return "\033[" . self::$foreground[$color] . "m" . $string . "\033[0m";
 }
 
 /**
  * Make string appear with background color
  */
 public static function bg_color($color, $string)
 {
  if (!isset(self::$background[$color]))
  {
   throw new Exception('Background color is not defined');
  }
 
  return "\033[" . self::$background[$color] . 'm' . $string . "\033[0m";
 }
 
 /**
  * See what they all look like
  */
 public static function all_fg()
 {
  foreach (self::$foreground as $color => $code)
  {
   echo "$color - " . self::fg_color($color, 'Hello, world!') . PHP_EOL;
  }
 }
 
 /**
  * See what they all look like
  */
 public static function all_bg()
 {
  foreach (self::$background as $color => $code)
  {
   echo "$color - " . self::bg_color($color, 'Hello, world!') . PHP_EOL;
  }
 }
}