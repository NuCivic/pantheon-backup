<?php

namespace PantheonBackup;

use PantheonBackup\TerminusWrapper;

class Pantheon {

  public $siteUUIDS = array();

  /**
   * New object constructor.
   *
   * @param $username
   * @param $password
   */
  public function __construct($username, $password) {
    $this->authenticate($username, $password);
    $this->getSiteNames();
  }

  /**
   * Authenticate a user.
   *
   * @param $username
   * @param $password
   */
  public function authenticate ($username, $password) {
    shell_exec("terminus auth login $username --password='$password'");
  }

  /**
   * Gets site names.
   *
   * @return array
   */
  public function getSiteNames() {
    $sites = TerminusWrapper::terminus_exec("sites list");
    foreach($sites as $key => $site) {
      $this->siteNames[] = $site->name;
    }

    return $this->siteNames;
  }
}
