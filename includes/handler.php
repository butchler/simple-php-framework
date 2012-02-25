<?php

/*
 * The Handler class is used to build a list of URL patterns using regular expressions, and determine what should be done if the URL matches each pattern.
 * 
 * Usage:
 *   $handler = new Handler();
 *   $handler->addPattern('<A regex that matches a set of URLs>', <A function>);
 *   $handler->addPattern('...', ...);
 *   ...
 *   $handler->handle();
 * 
 * Also provides some convenience functions to help create common callback functions.
 *
 */

class Handler
{
   // A list of URL patterns and their associated callback functions
   public $patterns = array();

   // Add a callback function to be called if the URL matches the given regular expression
   public function addPattern($pattern, $callback, $raw=false)
   {
      $newPattern->pattern = ($raw) ? $pattern : Handler::escapePattern($pattern);
      $newPattern->callback = $callback;

      $this->patterns[] = $newPattern;
   }

   // Go through the list of patterns and call the first one that matches.
   // Patterns are evaluated in the order they were added.
   public function handle($query, $config=NULL)
   {
      if (!isset($config))
         global $config;

      foreach ($this->patterns as $pattern)
      {
         // Escape #'s within the regular expression, because they are used as the starting and ending delimeters 
         $matched = preg_match($pattern->pattern, $query, $matches);

         if ($matched)
         {
            // If there were any parentheses groupings in the pattern, pass them along to the callback function
            $args = array_slice($matches, 1);

            $callback = $pattern->callback;
            $result = $callback($query, $args, $config);

            // If the callback returns false, we should keep on looking for other patterns. Otherwise, we are done.
            if ($result !== false)
               break;
         }
      }
   }

   // Add starting and ending delimeters around the given pattern, and escape any delimeters within it
   private static function escapePattern($pattern)
   {
      // Use # as the starting/ending delimeter for preg_replace()
      return '#' . preg_replace('/#/', '\#', $pattern) . '#';
   }

   // Helper functions to create some common handler functions
   // --------------------------------------------------------

   // Tries to include a .php file within the given directory based on the URL, and returns false if the file doesn't exist.
   // For example, if the URL is http://myawesomesite.com/myawesome/page and the directory is ./pages,
   // it will look for a file named ./pages/myawesome/page.php
   public static function dir($directory)
   {
      return function ($query, $args, $config) use ($directory) {
         $filename = "$directory/" . trim($query, '/') . '.php';

         if (file_exists($filename))
            return include($filename);
         else
            return false;
      };
   }

   // Just tries to include the given file, and returns false if it can't be included.
   public static function file($filename)
   {
      return function ($query, $args, $config) use ($filename) {
         if (file_exists($filename))
            return include($filename);
         else
            return false;
      };
   }
}

?>
