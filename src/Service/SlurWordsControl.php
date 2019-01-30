<?php
namespace App\Service;


/**
 *
 */
class SlurWordsControl
{
  public function replaceSlur(string $content): string
  {
    $slurWords = array("le", "la");
    $newContent = str_replace($slurWords, " # ", $content);
    return $newContent;
  }
}

 ?>
