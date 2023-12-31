<?php
  // $inputs = array("example.txt");
  // $inputs = array("input.txt");
  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);

    preg_match_all('/\d+\s\d+/', $lines[0], $matches);

    $seeds = array();

    foreach($matches[0] as $match) {
      $split = explode(' ', $match);
      $seeds[$split[0]] = $split[1];
    }

    $current_map = null;

    $maps = array(
      'seed-to-soil map:' => array(),
      'soil-to-fertilizer map:' => array(),
      'fertilizer-to-water map:' => array(),
      'water-to-light map:' => array(),
      'light-to-temperature map:' => array(),
      'temperature-to-humidity map:' => array(),
      'humidity-to-location map:' => array()
    );

    parse_maps($lines, $maps);

    $result = INF;

    foreach($seeds as $initial_location => $range) {
      for($i = $initial_location; $i <= $initial_location + $range; $i++) {
        $location = get_target_location($i, $maps);
        $result = min($result, $location);
      }
    }

    // 20191102
    echo $input . ": " . $result . "\n";
  }

  function parse_maps($lines, &$maps) {
    $current_map = null;

    foreach($lines as $line){
      if(str_contains($line, 'map')) {
        $current_map = $line;
        continue;
      }

      if($current_map === null) {
        continue;
      }

      preg_match('/(?P<dest>\d+)\s(?P<source>\d+)\s(?P<range>\d+)/', $line, $matches);

      $row = array('dest' => $matches['dest'], 'source' => $matches['source'], 'range' => $matches['range']);

      array_push($maps[$current_map], $row);
    }
  }

  function get_target_location($seed, &$maps) {
    $current_location = $seed;

    foreach($maps as $map => $rows) {
      foreach($rows as $row) {
        $source_range_start = $row['source'];
        $source_range_end = $row['source'] + $row['range'] - 1;

        if($current_location >= $source_range_start && $current_location <= $source_range_end) {
          $offset = $current_location - $source_range_start;
          $current_location = $row['dest'] + $offset;
          break;
        }
      }
    }

    return $current_location;
  }
?>
