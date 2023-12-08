<?php
  $inputs = array("input.txt");
  // $inputs = array("example.txt");
  // $inputs = array("example.txt", "input.txt");

  class Node {
    public $value, $left, $right;

    function __construct($value, $left, $right) {
      $this->value = $value;
      $this->left = $left;
      $this->right = $right;
    }
  }

  class Graph {
    public $path;
    public $current_step = 0, $nodes = array();
    public $starting_nodes = array();

    function __construct($path) {
      $this->path = $path;
    }

    function add_node($node) {
      if($node->value[2] === 'A') {
        $this->starting_nodes[] = $node;
      }

      $this->nodes[$node->value] = $node;
    }

    function walk() {
      $direction = $this->get_direction();

      foreach($this->starting_nodes as $index => $node) {
        if($direction === "L") {
          $this->starting_nodes[$index] = $this->nodes[$node->left];
        } else {
          $this->starting_nodes[$index] = $this->nodes[$node->right];
        }
      }
    }

    function get_direction() {
      $direction = $this->path[$this->current_step % strlen($this->path)];

      $this->current_step++;

      return $direction;
    }
  }

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);

    $graph = new Graph($lines[0]);

    for($i = 1; $i < count($lines); $i++) {
      preg_match('/(?P<value>[\d\D]{3}).+\((?P<left>[\d\D]{3}).+(?P<right>[\d\D]{3})\)/', $lines[$i], $matches);
      $node = new Node($matches['value'], $matches['left'], $matches['right']);

      $graph->add_node($node);
    }

    while(!reached_end($graph)) {
      $graph->walk();
    }

    $result = $graph->current_step;

    echo $input . ": " . $result . "\n";
  }

  function reached_end($graph) {
    $finished_nodes = 0;
    $total_nodes = count($graph->starting_nodes);

    foreach($graph->starting_nodes as $node) {
      if ($node->value[2] === 'Z') {
        $finished_nodes++;
      }
    }

    return $finished_nodes === $total_nodes;
  }
?>
