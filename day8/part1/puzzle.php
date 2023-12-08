<?php
  $inputs = array("example.txt", "input.txt");

  class Node {
    public $value, $left, $right;

    function __construct($value, $left, $right) {
      $this->value = $value;
      $this->left = $left;
      $this->right = $right;
    }
  }

  class Graph {
    public $path, $nodes;
    public $current_step, $current_node;

    function __construct($path) {
      $this->path = $path;
      $this->current_step = 0;
      $this->current_node = null;
      $this->nodes = array();
    }

    function add_node($node) {
      if($node->value === 'AAA') {
        $this->current_node = $node;
      }

      $this->nodes[$node->value] = $node;
    }

    function walk() {
      $direction = $this->get_direction();

      if($direction === "L") {
        $this->current_node = $this->nodes[$this->current_node->left];
      } else {
        $this->current_node = $this->nodes[$this->current_node->right];
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
      preg_match('/(?P<value>[\D]{3}).+\((?P<left>[\D]{3}).+(?P<right>[\D]{3})\)/', $lines[$i], $matches);

      $node = new Node($matches['value'], $matches['left'], $matches['right']);

      $graph->add_node($node);
    }

    while($graph->current_node->value !== 'ZZZ') {
      $graph->walk();
    }

    $result = $graph->current_step;

    echo $input . ": " . $result . "\n";
  }
?>
