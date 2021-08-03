<?php

use Mzur\GuessMIME\GuessMIME;
use PHPUnit\Framework\TestCase;

class GuessMIMETest extends TestCase
{
   public function testGuess()
   {
      $gm = new GuessMIME;
      $mime = $gm->guess('test.jpg');
      $this->assertEquals('image/jpeg', $mime);
   }

   public function testGuessCase()
   {
      $gm = new GuessMIME;
      $mime = $gm->guess('test.jPg');
      $this->assertEquals('image/jpeg', $mime);
   }

   public function testGuessMultiple()
   {
      $gm = new GuessMIME;
      $mime = $gm->guess('test.png.jpg');
      $this->assertEquals('image/jpeg', $mime);
   }

   public function testGuessDefault()
   {
      $gm = new GuessMIME;
      $mime = $gm->guess('test.abcxyz');
      $this->assertEquals('application/octet-stream', $mime);
   }

   public function testGuessNoExtension()
   {
      $gm = new GuessMIME;
      $mime = $gm->guess('test');
      $this->assertEquals('application/octet-stream', $mime);
   }

   public function testGuessNoExtensionStrict()
   {
      $gm = new GuessMIME;
      $mime = $gm->guess('test', true);
      $this->assertEquals(null, $mime);
   }

   public function testGuessOnly()
   {
      $gm = new GuessMIME(['image/jpeg']);
      $mime = $gm->guess('test.png');
      $this->assertEquals('application/octet-stream', $mime);

      $mime = $gm->guess('test.png', true);
      $this->assertEquals(null, $mime);

      $mime = $gm->guess('test.jpg');
      $this->assertEquals('image/jpeg', $mime);
   }
}
