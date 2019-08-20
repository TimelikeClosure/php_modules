<?php
require_once(__DIR__.'/../index.php');
?>
<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
    <?php
    $body = Module::get(__DIR__.'/body.php');
    if (isset($moduleScopedVariable)){
      echo '<h1>ERROR: Module scope isolation test failed!</h1>';
      exit();
    } else {
      echo $body;
    }
    echo Module::get(__DIR__.'/body.php');
    echo Module::get(__DIR__.'/subfolder/body.php');
    echo Module::get(__DIR__.'/body.php');
    try {
      Module::get(__DIR__.'/global_declarations.php');
      echo '<h1>ERROR: Module global declaration test failed!</h1>';
    } catch (Exception $error) {
      echo '<h1>Module global declaration test passed.</h1>';
    }
    ?> 
  </body>
</html>
