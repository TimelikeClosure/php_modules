<?php
$moduleScopedVariable = FALSE;
if (!isset($runCount)){
    $runCount = 0;
}
$runCount++;
$exports = '<h1>Welcome to the World of Modules!</h1>';
$exports .= "<p>This file has run $runCount times</p>";
