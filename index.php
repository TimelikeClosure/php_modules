<?php
require_once(__DIR__.'/dependencies.php');
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
    } else {
      echo $body;
    }
    ?> 
  </body>
</html>
