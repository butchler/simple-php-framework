<?php

include('./config.php');

// The default set of files to include
include_once("$config->rootDir/includes/handler.php");
include_once("$config->rootDir/includes/template.php");

// Set up your URL matching patterns here
$handler = new Handler();

// Some example patterns:
// The Handler::dir callback will try to include the file ./pages/$query if it exists, and will fail otherwise.
$handler->addPattern('.*', Handler::dir('./pages/'));
// If the user goes to the home page, call this function
$handler->addPattern('^$', function () { echo 'You should try going to /hello'; });
// If none of the above patterns succeed, fall back to 404.php
$handler->addPattern('.*', Handler::file('./404.php'));

// Handle the query
$query = (isset($_GET['query'])) ? $_GET['query'] : '';
$handler->handle($query);

?>
