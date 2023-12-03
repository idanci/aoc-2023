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

  $inputs = array("example.txt");

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

    // print_r($numbers);

    echo $input . ": " . $sum . "\n";

    fclose($myfile);
  }
?>
