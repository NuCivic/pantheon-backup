<?php

namespace PantheonBackup;

use PantheonBackup\DrushWrapper;

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
    $this->getSiteUUIDS();
  }

  /**
   * Authenticate a user.
   *
   * @param $username
   * @param $password
   */
  public function authenticate ($username, $password) {
    DrushWrapper::drush_exec("pantheon-auth $username --password=$password");
  }

  /**
   * Get the site uuids.
   *
   * @return array
   */
  public function getSiteUUIDS() {
    $sites = DrushWrapper::drush_exec("pantheon-sites");

    foreach($sites as $key=>$value) {
      $this->siteUUIDS[] = $key;
    }

    return $this->siteUUIDS;
  }
}
