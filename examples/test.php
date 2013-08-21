<?php

/**
 * @file
 * Read config test.
 */

$loader = require_once "vendor/autoload.php";

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

$pantheon_config = array();
try {
  $pantheon_config = Yaml::parse(file_get_contents('config.yml'));
  file_put_contents('/tmp/test.txt', var_export($pantheon_config, TRUE), FILE_APPEND);
}
catch (ParseException $e) {
  print $e->getMessage();
}
