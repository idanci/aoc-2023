<?php
  $inputs = array("example.txt", "input.txt");

  function parse_numbers($line, &$numbers) {
    foreach(explode(" ", $line) as $number) {
      $val = intval($number);
      if($val) {
        $numbers[] = $val;
      }
    }
  }

  function winning_numbers_sum($line) {
    $numbers = explode(":", $line)[1];

    $split = array_map('trim', explode("|", $numbers));

    $winning_numbers = [];
    $chosen_numbers = [];

    parse_numbers($split[0], $winning_numbers);
    parse_numbers($split[1], $chosen_numbers);

    $guessed_numbers = array_intersect($winning_numbers, $chosen_numbers);

    if(count($guessed_numbers) == 0) {
      return 0;
    }

    return pow(2, count($guessed_numbers) - 1);
  }

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);

    $sum = 0;

    foreach($lines as $line){
      $sum += winning_numbers_sum($line);
    }

    echo $input . ": " . $sum . "\n";
  }
?>
