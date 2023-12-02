<?php
  const BALLS = array('red' => 12, 'green' => 13, 'blue' => 14);

  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $myfile = fopen($input, "r") or die("Unable to open file!");

    $sum = 0;

    while(!feof($myfile)) {
      $line = fgets($myfile);

      // TODO
    }

    echo $input . ": " . $sum . "\n";

    fclose($myfile);
  }
?>
