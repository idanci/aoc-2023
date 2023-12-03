<?php
  class Part {
    public $value;
    public $x1, $x2, $row;

    function __construct($value, $row, $x1, $x2) {
      $this->value = $value;
      $this->row = $row;
      $this->x1 = $x1;
      $this->x2 = $x2;
    }
  }

  class Gear {
    public $row, $column;
    private $adjacent_columns;

    function __construct($row, $column) {
      $this->row = $row;
      $this->column = $column;

      $this->adjacent_columns = array($this->column - 1, $this->column, $this->column + 1);
    }

    function gear_ratio($parts) {
      $adjacent_parts = array();

      if(array_key_exists($this->row - 1, $parts)) {
        foreach($parts[$this->row - 1] as $part) {
          foreach($this->adjacent_columns as $col) {
            if (in_array($col, range($part->x1, $part->x2))) {
              if(in_array($part, $adjacent_parts)){
                continue;
              }
              array_push($adjacent_parts, $part);
            }
          }
        }
      }

      if(array_key_exists($this->row, $parts)) {
        foreach($parts[$this->row] as $part) {
          foreach($this->adjacent_columns as $col) {
            if (in_array($col, range($part->x1, $part->x2))) {
              if(in_array($part, $adjacent_parts)){
                continue;
              }
              array_push($adjacent_parts, $part);
            }
          }
        }
      }

      if(array_key_exists($this->row + 1, $parts)) {
        foreach($parts[$this->row + 1] as $part) {
          foreach($this->adjacent_columns as $col) {
            if (in_array($col, range($part->x1, $part->x2))) {
              if(in_array($part, $adjacent_parts)){
                continue;
              }
              array_push($adjacent_parts, $part);
            }
          }
        }
      }

      if(count($adjacent_parts) === 2){
        return $adjacent_parts[0]->value * $adjacent_parts[1]->value;
      }

      return 0;
    }
  }

  // $inputs = array("example.txt");
  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
    $height = count($lines);

    $parts = array_fill(0, $height, array());
    $gears = array();

    $sum = 0;

    foreach($lines as $row => $line){
      foreach(str_split($line) as $column => $char){
        if($char === '*'){
          $gear = new Gear($row, $column);
          array_push($gears, $gear);;
        }
      }

      populate_parts_from_line($row, $line, $parts);
    }

    foreach($gears as $gear){
      $sum += $gear->gear_ratio($parts);
    }

    echo $input . ": " . $sum . "\n";
  }

  function populate_parts_from_line($row, $line, &$parts) {
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
        $part = new Part(intval($numberStr), $row, $x1, $x2);
        array_push($parts[$row], $part);
        $numberStr = ''; // reset for the next number
      }
    }

    if ($numberStr !== '') {
      $x2 = $length - 1;
      $part = new Part(intval($numberStr), $row, $x1, $x2);
      array_push($parts, $part);
    }
  }
?>
