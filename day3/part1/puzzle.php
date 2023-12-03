<?php
  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $myfile = fopen($input, "r") or die("Unable to open file!");

    while(!feof($myfile)) {
      $line = fgets($myfile);

      if($line){
        //
      }
    }

    echo $input . ": " . $sum . "\n";

    fclose($myfile);
  }
?>
