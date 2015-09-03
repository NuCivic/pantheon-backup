<?php

namespace PantheonBackup;

class TerminusWrapper {
  /**
   * @param $cmd
   *
   * @return array|mixed
   */
  public static function terminus_exec ($cmd) {
    if (is_string($cmd)) {
      $json = shell_exec("terminus " . $cmd . " --json");

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
