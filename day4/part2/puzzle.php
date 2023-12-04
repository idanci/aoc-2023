<?php
  $inputs = array("example.txt", "input.txt");

  function parse_numbers($line) {
    $numbers = [];

    foreach(explode(" ", $line) as $number) {
      $val = intval($number);
      if($val) {
        $numbers[] = $val;
      }
    }

    return $numbers;
  }

  function process_line($line, $card_num, &$copies) {
    $numbers = explode(":", $line)[1];

    $split = array_map('trim', explode("|", $numbers));
    $winning_numbers = parse_numbers($split[0]);
    $chosen_numbers = parse_numbers($split[1]);

    $guessed_numbers = array_intersect($winning_numbers, $chosen_numbers);

    if(count($guessed_numbers) === 0) {
      return;
    }

    foreach(range(0, $copies[$card_num] - 1) as $i) {
      foreach(range($card_num + 1, $card_num + count($guessed_numbers)) as $num) {
        $copies[$num]++;
      }
    }
  }

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);

    $copies = array_fill(0, count($lines), 1);

    foreach($lines as $card_num => $line){
      process_line($line, $card_num, $copies);
    }

    echo $input . ": " . array_sum($copies) . "\n";
  }
?>
