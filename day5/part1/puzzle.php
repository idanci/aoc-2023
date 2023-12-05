<?php
  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);

    preg_match_all('/\d+/', $lines[0], $matches);
    $seeds = $matches[0];

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

    $target_locations = array();

    foreach($seeds as $initial_location) {
      $current_location = $initial_location;

      foreach($maps as $map => $rows) {
        foreach($rows as $row) {
          $source_range_start = $row['source'];
          $source_range_end = $row['source'] + $row['range'] - 1;

          if($current_location >= $source_range_start && $current_location <= $source_range_end) {
            // Calculate the offset of current_location within the source range
            $offset = $current_location - $source_range_start;
            // Add the offset to the start of the destination range
            $current_location = $row['dest'] + $offset;
            break;
          }
        }
      }

      $target_locations[$initial_location] = $current_location;
    }

    $result = min(array_values($target_locations));
    echo $input . ": " . $result . "\n";
  }
?>
