<?php
  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
    $result = 0;

    foreach($lines as $line) {
      //
    }

    echo $input . ": " . $result . "\n";
  }
?>
