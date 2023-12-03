<?php
  $inputs = array("example.txt");
  // $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $myfile = fopen($input, "r") or die("Unable to open file!");
    $matrix = array();
    $line_num = 0;

    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);

    foreach($lines as $line){
      $chars = str_split($line);
      $matrix[$line_num] = array();
      $index = 0;

      foreach($chars as $char){
        // echo '-' . $char . '-';
        $matrix[$line_num][$index] = $char;
        $index++;
      }

      echo print_r($matrix) . "\n";

      $line_num++;
    }

    fclose($myfile);
  }
?>
