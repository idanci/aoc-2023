<?php
  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $myfile = fopen($input, "r") or die("Unable to open file!");
    $sum = 0;

    while(!feof($myfile)) {
      $line = fgets($myfile);

      $chars = str_split($line);

      $first_digit = null;
      $last_digit = null;

      foreach($chars as $char){
        $int_char = intval($char);

        $is_letter = $int_char == 0;

        if($is_letter) {
          continue;
        }

        if($first_digit == null) {
          $first_digit = $int_char;
          $last_digit = $int_char;

          continue;
        }

        $last_digit = $int_char;
      }
      $sum += intval($first_digit . $last_digit);
    }

    echo $input . ": " . $sum . "\n";

    fclose($myfile);
  }
?>
