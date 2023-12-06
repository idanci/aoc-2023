<?php
  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);

    preg_match_all('/\d+/', $lines[0], $matches);
    $times = array_map('intval', $matches[0]);

    preg_match_all('/\d+/', $lines[1], $matches);
    $distances = array_map('intval', $matches[0]);

    $winnable = array();

    for($i = 0; $i < count($times); $i++) {
      $winnable[$i] = winnable_combinations($times[$i], $distances[$i]);
    }

    $result = 1;

    for($i = 0; $i < count($times); $i++) {
      if(array_key_exists($i, $winnable)) {
        $result = $result * $winnable[$i];
      }
    }
    echo $input . ": " . $result . "\n";
  }

  function winnable_combinations($time, $distance) {
    $combinations = 0;

    for($ms_held = 0; $ms_held < $time; $ms_held++) {
      $went_distance = ($time - $ms_held) * ($ms_held);

      if($went_distance > $distance) {
        $combinations++;
      }
    }

    return $combinations;
  }
?>
