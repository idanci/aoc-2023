<?php
  class Gear {
    public $x, $y;

    function __construct($x, $y) {
      $this->x = $x;
      $this->y = $y;
    }

    function gear_ratio($parts) {
      //
      return 0;
    }
  }

  $inputs = array("example.txt");
  // $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
    $height = count($lines);

    $numbers = array_fill(0, $height, array());
    $gears_matrix = array_fill(0, $height, array());

    $sum = 0;

    foreach($lines as $row => $line){
      foreach(str_split($line) as $column => $char){
        if($char === '*'){
          $gear = new Gear($row, $column);
          array_push($gears_matrix[$row], $gear);;
        }
      }
    }

    foreach($gears_matrix as $row => $gears){
      foreach($gears as $column){
        //
      }
    }

    // print_r($gears_matrix);

    echo $input . ": " . $sum . "\n";
  }
?>
