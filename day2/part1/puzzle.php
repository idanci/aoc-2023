<?php
  const BALLS = array('red' => 12, 'green' => 13, 'blue' => 14);

  $inputs = array("example.txt", "input.txt");

  foreach($inputs as $input) {
    $myfile = fopen($input, "r") or die("Unable to open file!");

    $sum = 0;

    while(!feof($myfile)) {
      $line = fgets($myfile);

      if($line){
        $sum += valid_games_ids($line);
      }
    }

    echo $input . ": " . $sum . "\n";

    fclose($myfile);
  }

  function possible_game($line) {
    $all_games_line = explode(":", $line)[1];
    $all_games = explode(";", $all_games_line);

    foreach($all_games as $game_line) {
      $colors = explode(",", $game_line);

      foreach($colors as $color) {
        $color_parts = explode(" ", $color);
        $color = trim($color_parts[count($color_parts) - 1]);
        $count = intval($color_parts[1]);

        if($count > BALLS[$color]) {
          return false;
        }
      }
    }

    return true;
  }

  function valid_games_ids($line) {
    $game_id = intval(explode(" ", explode(":", $line)[0])[1]);

    if(possible_game($line)) {
      return $game_id;
    }

    return 0;
  }
?>
