<?php

// It's a Hello, World! example!
$template = new PHPTemplate("$config->siteRoot/templates/basic.php");
$template->message = 'Hello, World!';
$template->render();

?>
