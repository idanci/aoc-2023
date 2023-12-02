<?php
  $inputs = array("example.txt", "input.txt");

  function calculate_product($line) {
    $all_games_line = explode(":", $line)[1];
    $all_games = explode(";", $all_games_line);

    $max_by_color = array('red' => 0, 'green' => 0, 'blue' => 0);

    foreach($all_games as $game_line) {
      $colors = explode(",", $game_line);

      foreach($colors as $color) {
        $color_parts = explode(" ", $color);

        $color = trim($color_parts[count($color_parts) - 1]);
        $count = intval($color_parts[1]);

        if($max_by_color[$color] < $count) {
          $max_by_color[$color] = $count;
        }
      }
    }

    $product = 1;

    foreach($max_by_color as $max_color) {
      if($max_color > 0){
        $product *= $max_color;
      }
    }

    return $product;
  }

  foreach($inputs as $input) {
    $myfile = fopen($input, "r") or die("Unable to open file!");

    $sum = 0;

    while(!feof($myfile)) {
      $line = fgets($myfile);

      if($line){
        $product_of_balls = calculate_product($line);
        $sum += $product_of_balls;
      }
    }

    echo $input . ": " . $sum . "\n";

    fclose($myfile);
  }
?>
