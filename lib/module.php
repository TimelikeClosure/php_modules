<?php

class Module {
  private static $cache = [];

  public static function &get($includePath){
    $includePath = realpath($includePath);
    if (!array_key_exists($includePath, self::$cache)){
      self::$cache[$includePath] = &self::wrapImport($includePath);
    }
    return self::$cache[$includePath];
  }

  private static function &wrapImport($includePath){
    $exports = [];
    require_once($includePath);
    return $exports;
  }
}
