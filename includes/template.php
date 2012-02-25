<?php

/*
 * Templates are used to separate content from layout/formatting.
 * 
 * Usage:
 *   $template = new PHPTemplate('templates/basic.php');
 *   $template->message = 'Hello, World';
 *   $template->render();
 * 
 * Where basic.php is something like this:
 *   <html>
 *   <body>
 *   <?php echo $this->message; ?>
 *   </body>
 *   </html>
 *
 */

interface Template
{
   function render();
}

class PHPTemplate
{
   function  __construct($templateFilename)
   {
      $this->templateFilename = $templateFilename;
   }

   function render()
   {
      include($this->templateFilename);
   }
}

?>
