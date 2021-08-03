<?php

namespace Mzur\GuessMIME;

class GuessMIME
{
   /**
    * Default MIME type.
    *
    * @var string
    */
   const DEFAULT_TYPE = 'application/octet-stream';

   /**
    * List of MIME types to limit the detection to.
    *
    * @var array
    */
   protected $only;

   /**
    * Path to the mime.types file of the system.
    *
    * @var string
    */
   protected $mimesPath;

   /**
    * Database of MIME types.
    *
    * @var array
    */
   protected $database;

   /**
    * Constructor.
    *
    * @param array $only List of MIME types to limit the detection to.
    * @param string $mimesPath Path to the mime.types file of the system.
    */
   public function __construct($only = [], $mimesPath = '/etc/mime.types')
   {
      $this->only = $only;
      $this->mimesPath = $mimesPath;
      $this->database = [];
   }

   /**
    * Guess the MIME type based on the file extension.
    *
    * @param string $filename
    *
    * @return string
    */
   public function guess($filename, $strict = false)
   {
      if (empty($this->database)) {
         $this->buildDatabase();
      }

      $extension = $this->getExtension($filename);

      if ($strict && !array_key_exists($extension, $this->database)) {
         return null;
      }

      return $this->database[$extension] ?? self::DEFAULT_TYPE;
   }

   /**
    * Build the database of MIME types.
    */
   protected function buildDatabase()
   {
      $handle = fopen($this->mimesPath, 'r');

      while (($line = fgets($handle)) !== false) {
         $line = trim($line);
         if (empty($line) || strpos($line, '#') === 0) {
            continue;
         }

         $cells = preg_split('/\s+/', $line);

         if (count($cells) <= 1) {
            continue;
         }

         if (!empty($this->only) && !in_array($cells[0], $this->only)) {
            continue;
         }

         $mime = array_shift($cells);

         foreach ($cells as $extension) {
            $this->database[$extension] = $mime;
         }

      }
   }

   /**
    * Get the normalized extension from a filename.
    *
    * @param string $filename
    *
    * @return string
    */
   protected function getExtension($filename)
   {
      return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
   }
}
