<?php

namespace PantheonBackup;

class DrushWrapper {
  /**
   * @param $cmd
   *
   * @return array|mixed
   */
  public static function drush_exec ($cmd) {
    if (is_string($cmd)) {
      $json = shell_exec("drush " . $cmd . " --json");

      $decoded = json_decode($json);
      if (is_object($decoded)) {
        $decoded = get_object_vars($decoded);
      }

      return $decoded;
    }
    else {
      return array();
    }
  }
}
