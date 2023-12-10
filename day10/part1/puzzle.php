<?php
  // $inputs = array("example.txt", "input.txt");
  $inputs = array("example.txt");

  function get_start_coordinates(&$map) {
    foreach($map as $y => $row) {
      foreach($row as $x => $symbol) {
        if($symbol === "S") {
          return array($x, $y);
        }
      }
    }
  }

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
    $map = array_map('str_split', $lines);

    $start_position = get_start_coordinates($map);


    // walk($start_position, $map);

    $result = 0;

    echo $input . ": " . $result . "\n";
  }

  function walk($start_position, &$map) {
    $visited = array();
    $visited[] = $start_position;

  }

  function directions($coordinates, &$map) {
    $symbol = $map[$coordinates[1]][$coordinates[0]];
    $directions = array();


    // return in_array($direction, CONNECTIONS[$tile->symbol]);

    // const CONNECTIONS = array(
    //   "|" => array("N", "S"),
    //   "-" => array("E", "W"),
    //   "L" => array("N", "E"),
    //   "J" => array("N", "W"),
    //   "7" => array("S", "W"),
    //   "F" => array("S", "E")
    // );

    // | is a vertical pipe connecting north and south.
    // - is a horizontal pipe connecting east and west.
    // L is a 90-degree bend connecting north and east.
    // J is a 90-degree bend connecting north and west.
    // 7 is a 90-degree bend connecting south and west.
    // F is a 90-degree bend connecting south and east.
  }
?>
