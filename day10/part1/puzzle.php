<?php
  $inputs = array("example.txt", "input.txt");

  const CONNECTIONS = array(
    "N" => ['|', 'L', 'J'],
    "S" => ['|', '7', 'F'],
    "W" => ['-', 'J', '7'],
    "E" => ['-', 'L', 'F']
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
      $next_pipe_coords = next_pipe_coordinates($path, $map);
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
    $symbol = $map[$current_row - 1][$current_column];
    if(in_array($symbol, CONNECTIONS['S'])) return [$current_row - 1, $current_column];

    $symbol = $map[$current_row + 1][$current_column];
    if(in_array($symbol, CONNECTIONS['N'])) return [$current_row + 1, $current_column];

    $symbol = $map[$current_row][$current_column - 1];
    if(in_array($symbol, CONNECTIONS['E'])) return [$current_row, $current_column - 1];

    $symbol = $map[$current_row][$current_column + 1];
    if(in_array($symbol, CONNECTIONS['W'])) return [$current_row, $current_column + 1];
  }

  function north_tile_coordinates($symbol, $current_row, $current_column, &$map) {
    if(in_array($symbol, CONNECTIONS['N'])) return [$current_row - 1, $current_column];
  }

  function south_tile_coordinates($symbol, $current_row, $current_column, &$map) {
    if(in_array($symbol, CONNECTIONS['S'])) return [$current_row + 1, $current_column];
  }

  function west_tile_coordinates($symbol, $current_row, $current_column, &$map) {
    if(in_array($symbol, CONNECTIONS['W'])) return [$current_row, $current_column - 1];
  }

  function east_tile_coordinates($symbol, $current_row, $current_column, &$map) {
    if(in_array($symbol, CONNECTIONS['E'])) return [$current_row, $current_column + 1];
  }

  function next_pipe_coordinates(&$path, &$map) {
    $current_pipe_coordinates = end($path);

    $row = $current_pipe_coordinates[0];
    $column = $current_pipe_coordinates[1];
    $symbol = $map[$row][$column];

    $north_coords = north_tile_coordinates($symbol, $row, $column, $map);
    if(valid_path($north_coords, $path)) return $north_coords;

    $south_coords = south_tile_coordinates($symbol, $row, $column, $map);
    if(valid_path($south_coords, $path)) return $south_coords;

    $west_coords = west_tile_coordinates($symbol, $row, $column, $map);
    if(valid_path($west_coords, $path)) return $west_coords;

    $east_coords = east_tile_coordinates($symbol, $row, $column, $map);
    if(valid_path($east_coords, $path)) return $east_coords;
  }

  function valid_path($coords, &$path) {
    if($coords === null) return false;

    if(!in_array($coords, $path)) {
      $path[] = $coords;
      return true;
    }
  }
?>
