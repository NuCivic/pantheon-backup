<?php

/**
 * @file
 * Execute backups for pantheon.
 */

namespace PantheonBackup;

use PantheonBackup\DrushWrapper;
use PantheonBackup\Pantheon;

class PantheonBackup extends Pantheon {

  /**
   * New object constructor.
   *
   * @param $username
   * @param $password
   */
  public function __construct($username, $password) {
    parent::__construct($username, $password);
  }

  public function createBackup($siteID, $env) {

  }

  /**
   * Get information on all available backups for this site and environment.
   *
   * @param $siteID
   * @param $environment [dev, test, live]
   *
   * @return array|mixed
   */
  public function getBackupInformation($siteID, $environment, $type = NULL) {
    $result = DrushWrapper::drush_exec("pantheon-site-backups $siteID $environment");

    if (!is_null($type)) {
      foreach ($result as $filename => $data) {
        if ($data[0] == 'export' || $data[2] != $type) {
          unset($result[$filename]);
        }
      }
    }

    return $result;
  }

  /**
   * Get information only on the latest backup for this site and environment.
   *
   * @param $siteID
   * @param $environment
   *
   * @return mixed
   */
  public function getLatestBackupInformation($siteID, $environment, $type = NULL) {
    $result = $this->getBackupInformation($siteID, $environment, $type);
    if (is_null($type)) {
      return array_slice($result, 0, 3, TRUE);
    }
    else {
      return array_slice($result, 0, 1, TRUE);
    }
  }

  /**
   * Get the download URL for a specific backup.
   *
   * @param $siteID
   * @param $environment
   * @param $bucket
   * @param $type
   *
   * @return mixed
   */
  public function getBackupURL($siteID, $environment, $bucket, $type) {
    $result = DrushWrapper::drush_exec("pantheon-site-get-backup $siteID $environment $bucket $type");
    return $result['url'];
  }


  /**
   * Download a backup to the specified filename.
   *
   * @param $filename
   * @param $backup_url
   */
  public function downloadBackup($filename, $backup_url) {
    file_put_contents($filename, fopen($backup_url, 'r'));
  }
}
