<?php
  class Number {
    public $value;
    public $x1, $x2, $row;

    function __construct($value,  $row, $x1, $x2) {
      $this->value = $value;
      $this->row = $row;
      $this->x1 = $x1;
      $this->x2 = $x2;
    }
  }

  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $myfile = fopen($input, "r") or die("Unable to open file!");
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
    $numbers = array();
    $symbols = array_fill(0, count($lines), array());
    $sum = 0;

    foreach($lines as $row => $line){
      preg_match_all('/[0-9]+/', $line, $number_matches);

      foreach($number_matches[0] as $num){
        $x1 = strpos($line, strval($num));
        $x2 = $x1 + strlen($num) - 1;

        $number = new Number($num, $row, $x1, $x2);

        array_push($numbers, $number);
      }

      $chars = str_split($line);

      foreach($chars as $column => $char){
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

    fclose($myfile);
  }

  function is_part($number, $symbols) {
    // 1. If row above has a symbol in ($number->x1 - 1 .. $number->x2 + 1) return true
    // 2. If row below has a symbol in ($number->x1 - 1 .. $number->x2 + 1) return true
    // 3. If same row has a symbol in ($number->x1 - 1 .. $number->x2 + 1) return true

    $total_rows = count($symbols);
    $row = $number->row;

    $left_bound = $number->x1 === 0 ? $number->x1 : $number->x1 - 1;
    $right_bound = $number->x2 === $total_rows - 1 ? $number->x2 - 1 : $number->x2 + 1;

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
      if(array_key_exists($left_bound, $symbols[$row])){
        return true;
      }
      if(array_key_exists($right_bound, $symbols[$row])){
        return true;
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
