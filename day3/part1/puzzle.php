<?php
  class Number {
    public $value;
    public $x1, $x2, $row;

    function __construct($value, $row, $x1, $x2) {
      $this->value = $value;
      $this->row = $row;
      $this->x1 = $x1;
      $this->x2 = $x2;
    }
  }

  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
    $numbers = array();
    $symbols = array_fill(0, count($lines), array());
    $sum = 0;

    foreach($lines as $row => $line){
      populate_numbers_from_line($row, $line, $numbers);

      foreach(str_split($line) as $column => $char){
        if($char === '.' || is_numeric($char)){
          continue;
        }

        array_push($symbols[$row], $column);
      }
    }

    foreach($numbers as $num){
      if(is_part($num, $symbols)){
        $sum += $num->value;
      }
    }

    echo $input . ": " . $sum . "\n";
  }

  function populate_numbers_from_line($row, $line, &$numbers) {
    $numberStr = '';
    $x1 = 0;
    $length = strlen($line);

    for ($i = 0; $i < $length; $i++) {
      if (is_numeric($line[$i])) {
        if ($numberStr === '') {
          $x1 = $i; // start of a new number
        }
        $numberStr .= $line[$i];
      } elseif ($numberStr !== '') {
        $x2 = $i - 1;
        $number = new Number(intval($numberStr), $row, $x1, $x2);
        array_push($numbers, $number);
        $numberStr = ''; // reset for the next number
      }
    }

    if ($numberStr !== '') {
      $x2 = $length - 1;
      $number = new Number(intval($numberStr), $row, $x1, $x2);
      array_push($numbers, $number);
    }
  }

  function is_part($number, $symbols) {
    // 1. If row above has a symbol in ($number->x1 - 1 .. $number->x2 + 1) return true
    // 2. If row below has a symbol in ($number->x1 - 1 .. $number->x2 + 1) return true
    // 3. If same row has a symbol in ($number->x1 - 1 .. $number->x2 + 1) return true

    $total_rows = count($symbols);
    $row = $number->row;

    $left_bound = $number->x1 === 0 ? $number->x1 : $number->x1 - 1;
    $right_bound = $number->x2 === $total_rows - 1 ? $number->x2 : $number->x2 + 1;

    // row above
    if(array_key_exists($row - 1, $symbols)) {
      foreach($symbols[$row - 1] as $col) {
        if (in_array($col, range($left_bound, $right_bound))) {
          return true;
        }
      }
    }

    // same row
    if(array_key_exists($row, $symbols)) {
      foreach($symbols[$row] as $col) {
        if (in_array($col, range($left_bound, $right_bound))) {
          return true;
        }
      }
    }

    // row below
    if(array_key_exists($row + 1, $symbols)) {
      foreach($symbols[$row + 1] as $col) {
        if (in_array($col, range($left_bound, $right_bound))) {
          return true;
        }
      }
    }

    return false;
  }
?>
