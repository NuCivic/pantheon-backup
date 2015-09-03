<?php

/**
 * @file
 * Execute backups for pantheon.
 */

namespace PantheonBackup;

use PantheonBackup\TerminusWrapper;
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

  /**
   * Start a backup for the given site and environment.
   *
   * @param $siteName
   * @param $env
   */
  public function createBackup($siteName, $dir, $env = "prod", $element = 'all') {
    return TerminusWrapper::terminus_exec("site backup create --site=$siteName --env=$env --element=$element --to-direcotry=$dir");
  }

  /**
   * Start a backup for the given site and environment.
   *
   * @param $siteName
   * @param $env
   */
  public function getBackup($siteName, $dir, $env = "prod", $element = 'all') {
    TerminusWrapper::terminus_exec("site backup get --site=$siteName --env=$env --element=$element --to-direcotry=$dir --latest");
  }

  /**
   * Get information on all available backups for this site and environment.
   *
   * @param $siteName
   * @param $environment [dev, test, live]
   *
   * @return array|mixed
   */
  public function getBackupInformation($siteName, $env) {
    return = TerminusWrapper::terminus_exec("site backup list --site=$siteName --env=$env");
  }

  /**
   * Get information only on the latest backup for this site and environment.
   *
   * @param $siteName
   * @param $environment
   *
   * @return mixed
   */
  public function getLatestBackupInformation($siteName, $environment, $type = NULL) {
    $result = $this->getBackupInformation($siteName, $environment, $type);
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
   * @param $siteName
   * @param $environment
   * @param $bucket
   * @param $type
   *
   * @return mixed
   */
  public function getBackupURL($siteName, $environment, $bucket, $type) {
    return TerminusWrapper::terminus_exec("site backup get --site=$siteName --env=$env --element=$element --latest");
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
