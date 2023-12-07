<?php
  $inputs = array("example.txt");
  // $inputs = array("example.txt", "input.txt");

  const CARDS = array("2", "3", "4", "5", "6", "7", "8", "9", "T", "J", "Q", "K", "A");

  const POWER = array(
    "kicker" => 1,
    "one_pair" => 2,
    "two_pairs" => 3,
    "three_of_a_kind" => 4,
    "full_house" => 5,
    "four_of_a_kind" => 6,
    "five_of_a_kind" => 7
  );

  class Hand {
    public $cards, $bid;
    public $power, $combination;

    function __construct($cards, $bid) {
      $this->cards = $cards;
      $this->bid = $bid;
      $this->set_combination();
      $this->power = POWER[$this->combination];
    }

    function set_combination() {
      preg_match_all('/(\d|\D)/', $this->cards, $matches);
      $uniques = array_count_values($matches[0]);

      $vals = array_values($uniques);
      rsort($vals);

      if($vals[0] === 5) {
        $this->combination = "five_of_a_kind";
      } else if($vals[0] === 4) {
        $this->combination = "four_of_a_kind";
      } else if($vals[0] === 3 && $vals[1] === 2) {
        $this->combination = "full_house";
      } else if($vals[0] === 3) {
        $this->combination = "three_of_a_kind";
      } else if($vals[0] === 2 && $vals[1] === 2) {
        $this->combination = "two_pairs";
      } else if($vals[0] === 2) {
        $this->combination = "one_pair";
      } else {
        $this->combination = "kicker";
      }
    }
  }

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);

    $hands = array();

    foreach($lines as $line) {
      $split = explode(" ", $line);
      $hands[] = new Hand($split[0], $split[1]);
    }

    usort($hands, "compare_hands");

    print_r($hands);

    $result = null;

    echo $input . ": " . $result . "\n";
  }

  function compare_hands($hand_1, $hand_2) {
    return $hand_1->power <=> $hand_2->power;
  }
?>
