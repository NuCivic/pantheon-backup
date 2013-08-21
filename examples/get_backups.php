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
  foreach ($backup->siteUUIDS as $site) {
    // And each environment within each site
    foreach (array('dev', 'live') as $environment) {
      // Download the files, code, and database
      $backups = $backup->getLatestBackupInformation($site, $environment);
      foreach ($backups as $filename => $backup_info) {
        var_dump($filename, $backup_info);
        $backup_url = $backup->getBackupURL($site, $environment, $backup_info[3], $backup_info[2]);
        var_dump($backup_url);
        $backup->downloadBackup($pantheon_config['download_dir'] . $filename, $backup_url);
      }
    }
  }
}
