<?php

class Module {
  private static $cache = [];

  public static function &get($includePath){
    $includePath = realpath($includePath);

    if (!array_key_exists($includePath, self::$cache)){
      self::$cache[$includePath] = &self::wrapImport($includePath);
    }
    $exports = & self::$cache[$includePath];
    if (is_array($exports)){
      $exports = array_map(function &(&$element){
        return $element;
      }, $exports);
    }
    return $exports;
  }

  private static function &wrapImport($includePath){
    $importScope = &self::importScope($includePath);
    return $importScope;
  }

  private static function &enforcePurity(&$wrappedFunction){
    $functionWrapper = function &(&...$args) use (&$wrappedFunction){
      $globalDeclarationsBeforeImport = self::getGlobalDeclareCounts();
      $wrappedFunctionResult = &$wrappedFunction(...$args);
      $globalDeclarationsAfterImport = self::getGlobalDeclareCounts();
      if ($globalDeclarationsAfterImport !== $globalDeclarationsBeforeImport){
        throw new Exception('INVALID MODULE: Modules cannot produce side effects.');
      }
      return $wrappedFunctionResult;
    };
    return $functionWrapper;
  }

  private static function getGlobalDeclareCounts(){
    $definedFunctionsCount = count(get_defined_functions()['user']);
    $declaredClassesCount = count(get_declared_classes());
    $declaredTraitsCount = count(get_declared_traits());
    $declaredInterfacesCount = count(get_declared_interfaces());
    return $definedFunctionsCount + $declaredClassesCount + $declaredTraitsCount + $declaredInterfacesCount;
  }

  private static function &importScope($includePath){
    $importScope = function &($includePath){
      $exports = [];
      require_once($includePath);
      return $exports;
    };

    $module = &self::enforcePurity($importScope)($includePath);

    return $module;
  }
}
