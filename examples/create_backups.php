<?php

/**
 * @file
 * Sample script to pull the backups for all of the Pantheon sites.
 */

$loader = require_once "vendor/autoload.php";

use PantheonBackup\PantheonBackup;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

$pantheon_config = array();
try {
  $pantheon_config = Yaml::parse(file_get_contents('config.yml'));
}
catch (ParseException $e) {
  print $e->getMessage();
}

{
  $backup = new PantheonBackup($pantheon_config['username'], $pantheon_config['password']);
  // For every site
  foreach ($backup->siteNames as $site) {
    print "\n\nCreating backups for $site:\n";
    // And each environment within each site
    foreach (array('dev', 'live') as $environment) {
      print "  $environment\n";
      // Create a backup of files, code, database.
      $backup->createBackup($site, $pantheon_config['download_dir'], $environment);
    }
  }
}
