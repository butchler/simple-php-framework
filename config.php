<?php

$config->siteRoot = realpath('.');
$config->siteURL = $_SERVER['SERVER_NAME'] . substr($config->siteRoot, strlen($_SERVER['DOCUMENT_ROOT']));

// You can use this file to store things like your database login information:
//$config->databaseHost = '...';
//$config->databasePort = '...';
//$config->databaseUsername = '...';
//$config->databasePassword = '...';

?>
