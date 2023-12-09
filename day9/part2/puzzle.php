<?php
  $inputs = array("example.txt", "input.txt");

  class History {
    public $rows = array();
    private $current_row, $generation_complete = false;

    function __construct($values) {
      $this->current_row = $values;
      $this->rows[] = $values;
    }

    function extrapolate_last_value() {
      $total_rows = count($this->rows);

      for($i = $total_rows - 2; $i >= 0; $i--) {
        $first_value_in_current = $this->rows[$i][0];
        $first_value_in_previous = $this->rows[$i + 1][0];

        array_unshift($this->rows[$i], $first_value_in_current - $first_value_in_previous);
      }
    }

    function get_first_value() {
      $this->generate_rows();
      $this->extrapolate_last_value();

      return $this->rows[0][0];
    }

    function generate_rows() {
      while(!$this->generation_complete) {
        $this->generation_complete = true;
        $this->generate_next_row();
      }

      $this->rows[count($this->rows) - 1][] = 0;
    }

    function generate_next_row() {
      $next_row = array();
      $numbers_to_generate = count($this->current_row) - 1;

      for($i = 0; $i < $numbers_to_generate; $i++) {
        $next_row_val = $this->current_row[$i + 1] - $this->current_row[$i];

        if($next_row_val !== 0) {
          $this->generation_complete = false;
        }

        $next_row[] = $next_row_val;
      }

      $this->rows[] = $next_row;
      $this->current_row = $next_row;
    }
  }

  foreach($inputs as $input) {
    $lines = file($input, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
    $result = 0;

    foreach($lines as $line) {
      $result += process_sequence($line);
    }

    echo $input . ": " . $result . "\n";
  }

  function process_sequence($line) {
    $nums = array_map('intval', explode(" ", $line));

    $history = new History($nums);

    return $history->get_first_value();
  }
?>
