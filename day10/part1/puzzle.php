<?php
  $inputs = array("example.txt", "input.txt");

  const CONNECTIONS = array(
    "N" => array('symbols' => ['|', 'L', 'J'], 'offset' => [-1, 0]),
    "S" => array('symbols' => ['|', '7', 'F'], 'offset' => [1, 0]),
    "W" => array('symbols' => ['-', 'J', '7'], 'offset' => [0, -1]),
    "E" => array('symbols' => ['-', 'L', 'F'], 'offset' => [0, 1])
  );

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
    $map = array_map('str_split', $lines);

    $start_position = get_start_coordinates($map);

    $path = walk($start_position, $map);

    $result = count($path) / 2;

    echo $input . ": " . $result . "\n";
  }

  function walk($start_position, &$map) {
    $path = array();
    $path[] = $start_position;

    $step_two_coords = second_tile_coordinates($start_position[0], $start_position[1], $map);
    $path[] = $step_two_coords;

    do {
      $next_pipe_coords = next_tile_coordinates($path, $map);
    } while($next_pipe_coords !== null);

    return $path;
  }

  function get_start_coordinates(&$map) {
    foreach($map as $row_index => $row) {
      foreach($row as $column_index => $symbol) {
        if($symbol === "S") return array($row_index, $column_index);
      }
    }
  }

  function second_tile_coordinates($current_row, $current_column, &$map) {
    $symbol = $map[$current_row + 1][$current_column];
    if(in_array($symbol, CONNECTIONS['N']['symbols'])) return [$current_row + 1, $current_column];

    $symbol = $map[$current_row][$current_column + 1];
    if(in_array($symbol, CONNECTIONS['W']['symbols'])) return [$current_row, $current_column + 1];

    $symbol = $map[$current_row - 1][$current_column];
    if(in_array($symbol, CONNECTIONS['S']['symbols'])) return [$current_row - 1, $current_column];

    $symbol = $map[$current_row][$current_column - 1];
    if(in_array($symbol, CONNECTIONS['E']['symbols'])) return [$current_row, $current_column - 1];
  }

  function next_tile_coordinates(&$path, &$map) {
    $current_tile_coordinates = end($path);

    $row = $current_tile_coordinates[0];
    $column = $current_tile_coordinates[1];
    $symbol = $map[$row][$column];

    return move($symbol, $row, $column, $path);
  }

  function move($symbol, $current_row, $current_column, &$path) {
    foreach(CONNECTIONS as $direction => $metadata) {
      if(in_array($symbol, $metadata['symbols'])) {
        $coords = [$current_row + $metadata['offset'][0], $current_column + $metadata['offset'][1]];
        if(!in_array($coords, $path)) {
          $path[] = $coords;
          return $coords;
        }
      }
    }
  }
?>
