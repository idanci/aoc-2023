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
    public $starting_nodes = array();

    function __construct($path) {
      $this->path = $path;
      $this->current_step = 0;
      $this->current_node = null;
      $this->nodes = array();
    }

    function add_node($node) {
      if($node->value[2] === 'A') {
        $this->starting_nodes[] = $node;
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

    function reset($starting_node) {
      $this->current_step = 0;
      $this->current_node = $starting_node;
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

    $result = array();

    foreach($graph->starting_nodes as $starting_node) {
      $graph->reset($starting_node);

      while($graph->current_node->value[2] !== 'Z') {
        $graph->walk();
      }

      $result[$graph->current_node->value] = $graph->current_step;
    }

    $result = least_common_multiple(array_values($result));

    echo $input . ": " . $result . "\n";
  }

  // snatched from stackoverflow
  function greatest_common_divisor($a, $b){
    if ($b == 0)
      return $a;

    return greatest_common_divisor($b, $a % $b);
  }

  function least_common_multiple($array) {
    $n = count($array);
    $result = $array[0];

    for ($i = 1; $i < $n; $i++)
      $result = ((($array[$i] * $result)) / (greatest_common_divisor($array[$i], $result)));

    return $result;
  }
?>
