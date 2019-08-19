<?php

class Module {
  private static $cache = [];

  public static get function($includePath){
    $includePath = realpath($includePath);
    if (!array_key_exists($includePath, $this->cache)){
      $this->cache = & $this->wrapImport($includePath);
    }
    return &$this->cache[$includePath];
  }

  private static wrapImport($includePath){
    $exports = [];
    require_once($includePath);
    return & $exports;
  }
}
