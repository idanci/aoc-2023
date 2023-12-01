<?php
  const MAP = array(
    'one'   => 1, '1' => 1,
    'two'   => 2, '2' => 2,
    'three' => 3, '3' => 3,
    'four'  => 4, '4' => 4,
    'five'  => 5, '5' => 5,
    'six'   => 6, '6' => 6,
    'seven' => 7, '7' => 7,
    'eight' => 8, '8' => 8,
    'nine'  => 9, '9' => 9
  );

  function get_and_first_and_last_digit($line) {
    $acc = array();

    $min_index = null;
    $max_index = null;

    $min_val = null;
    $max_val = null;

    foreach(MAP as $str => $num) {
      $first_index = strpos($line, $str);
      $last_index = strrpos($line, $str);

      if ($first_index === false) {
        continue;
      }

      if($min_index === null) {
        $min_index = $first_index;
        $max_index = $last_index;
        $min_val = $num;
        $max_val = $num;

        continue;
      }

      if($first_index < $min_index) {
        $min_index = $first_index;
        $min_val = $num;
      }

      if($last_index > $max_index) {
        $max_index = $last_index;
        $max_val = $num;
      }
    }

    return array($min_val, $max_val);
  }

  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $myfile = fopen($input, "r") or die("Unable to open file!");

    $sum = 0;

    while(!feof($myfile)) {
      $line = fgets($myfile);

      $bounds = get_and_first_and_last_digit($line);

      $sum += intval($bounds[0] . $bounds[1]);
    }

    echo $input . ": " . $sum . "\n";

    fclose($myfile);
  }
?>
