<?php
  $inputs = array("example.txt", "input.txt");

  // const CONNECTIONS = array(
  //   "|" => array("N", "S"),
  //   "-" => array("E", "W"),
  //   "L" => array("N", "E"),
  //   "J" => array("N", "W"),
  //   "7" => array("S", "W"),
  //   "F" => array("S", "E")
  // );

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
    if(array_key_exists($current_row - 1, $map)) {
      if(array_key_exists($current_column, $map[$current_row - 1])) {
        $symbol = $map[$current_row - 1][$current_column];
        if(in_array($symbol, ['|', '7', 'F'])) {
          return [$current_row - 1, $current_column];
        }
      }
    }

    if(array_key_exists($current_row + 1, $map)) {
      if(array_key_exists($current_column, $map[$current_row + 1])) {
        $symbol = $map[$current_row + 1][$current_column];
        if(in_array($symbol, ['|', 'L', 'J'])) {
          return [$current_row + 1, $current_column];
        }
      }
    }

    if(array_key_exists($current_row, $map)) {
      if(array_key_exists($current_column - 1, $map[$current_row])) {
        $symbol = $map[$current_row][$current_column - 1];
        if(in_array($symbol, ['-', 'L', 'F'])) {
          return [$current_row, $current_column - 1];
        }
      }
    }

    if(array_key_exists($current_row, $map)) {
      if(array_key_exists($current_column + 1, $map[$current_row])) {
        $symbol = $map[$current_row][$current_column + 1];
        if(in_array($symbol, ['-', 'J', '7'])) {
          return [$current_row, $current_column + 1];
        }
      }
    }
  }

  function north_tile_coordinates($current_row, $current_column, &$map) {
    $symbol = $map[$current_row][$current_column];

    if(in_array($symbol, ['|', 'L', 'J'])) {
      return [$current_row - 1, $current_column];
    }

    return null;
  }

  function south_tile_coordinates($current_row, $current_column, &$map) {
    $symbol = $map[$current_row][$current_column];

    if(in_array($symbol, ['|', '7', 'F'])) {
      return [$current_row + 1, $current_column];
    }

    return null;
  }

  function west_tile_coordinates($current_row, $current_column, &$map) {
    $symbol = $map[$current_row][$current_column];

    if(in_array($symbol, ['-', 'J', '7'])) {
      return [$current_row, $current_column - 1];
    }

    return null;
  }

  function east_tile_coordinates($current_row, $current_column, &$map) {
    $symbol = $map[$current_row][$current_column];

    if(in_array($symbol, ['-', 'L', 'F'])) {
      return [$current_row, $current_column + 1];
    }

    return null;
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
