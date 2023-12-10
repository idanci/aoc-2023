<?php
  $inputs = array("example.txt", "input.txt");

  const CONNECTIONS = array(
    "NORTH" => ['|', 'L', 'J'],
    "SOUTH" => ['|', '7', 'F'],
    "WEST" => ['-', 'J', '7'],
    "EAST" => ['-', 'L', 'F']
  );

  function get_start_coordinates(&$map) {
    foreach($map as $row_index => $row) {
      foreach($row as $column_index => $symbol) {
        if($symbol === "S") {
          return array($row_index, $column_index);
        }
      }
    }
  }

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
    $map = array_map('str_split', $lines);

    $start_position = get_start_coordinates($map);

    $path = walk($start_position, $map);

    $result = count($path) / 2;

    echo $input . ": " . $result . "\n";
  }

  function path_complete(&$path, &$map) {
    $last_pipe = end($path);

    if($last_pipe === null) {
      return false;
    }

    $row = $last_pipe[0];
    $column = $last_pipe[1];
    $symbol = $map[$row][$column];

    $symbol === "S";
  }

  function walk($current_pipe_coordinates, &$map) {
    $path = array();
    $path[] = $current_pipe_coordinates;

    while(!path_complete($path, $map)) {
      $next_pipe_coords = next_pipe_coordinates($path, $map);

      if($next_pipe_coords === null) {
        break;
      }

      $row = $next_pipe_coords[0];
      $column = $next_pipe_coords[1];

      if($next_pipe_coords === null || $map[$row][$column] === "S") {
        break;
      }
    }

    return $path;
  }

  function step_two_tile_coordinates($current_row, $current_column, &$map) {
    $symbol = $map[$current_row - 1][$current_column];
    if(in_array($symbol, CONNECTIONS['SOUTH'])) {
      return [$current_row - 1, $current_column];
    }

    $symbol = $map[$current_row + 1][$current_column];
    if(in_array($symbol, CONNECTIONS['NORTH'])) {
      return [$current_row + 1, $current_column];
    }

    $symbol = $map[$current_row][$current_column - 1];
    if(in_array($symbol, CONNECTIONS['EAST'])) {
      return [$current_row, $current_column - 1];
    }

    $symbol = $map[$current_row][$current_column + 1];
    if(in_array($symbol, CONNECTIONS['WEST'])) {
      return [$current_row, $current_column + 1];
    }
  }

  function north_tile_coordinates($current_row, $current_column, &$map) {
    $symbol = $map[$current_row][$current_column];

    if(in_array($symbol, CONNECTIONS['NORTH'])) {
      return [$current_row - 1, $current_column];
    }
  }

  function south_tile_coordinates($current_row, $current_column, &$map) {
    $symbol = $map[$current_row][$current_column];

    if(in_array($symbol, CONNECTIONS['SOUTH'])) {
      return [$current_row + 1, $current_column];
    }
  }

  function west_tile_coordinates($current_row, $current_column, &$map) {
    $symbol = $map[$current_row][$current_column];

    if(in_array($symbol, CONNECTIONS['WEST'])) {
      return [$current_row, $current_column - 1];
    }
  }

  function east_tile_coordinates($current_row, $current_column, &$map) {
    $symbol = $map[$current_row][$current_column];

    if(in_array($symbol, CONNECTIONS['EAST'])) {
      return [$current_row, $current_column + 1];
    }
  }

  function next_pipe_coordinates(&$path, &$map) {
    $current_pipe_coordinates = end($path);

    $row = $current_pipe_coordinates[0];
    $column = $current_pipe_coordinates[1];

    $symbol = $map[$row][$column];

    if ($symbol === "S") {
      $step_two_coords = step_two_tile_coordinates($row, $column, $map);
      $path[] = $step_two_coords;
      return $step_two_coords;
    }

    $north_coords = north_tile_coordinates($row, $column, $map);
    if($north_coords !== null) {
      if(!in_array($north_coords, $path)) {
        $path[] = $north_coords;
        return $north_coords;
      }
    }

    $south_coords = south_tile_coordinates($row, $column, $map);
    if($south_coords !== null) {
      if(!in_array($south_coords, $path)) {
        $path[] = $south_coords;
        return $south_coords;
      }
    }

    $west_coords = west_tile_coordinates($row, $column, $map);
    if($west_coords !== null) {
      if(!in_array($west_coords, $path)) {
        $path[] = $west_coords;
        return $west_coords;
      }
    }

    $east_coords = east_tile_coordinates($row, $column, $map);
    if($east_coords !== null) {
      if(!in_array($east_coords, $path)) {
        $path[] = $east_coords;
        return $east_coords;
      }
    }
  }
?>
