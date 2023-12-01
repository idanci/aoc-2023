<?php
  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $myfile = fopen($input, "r") or die("Unable to open file!");

    // TODO

    fclose($myfile);
  }
?>
