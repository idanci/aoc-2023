<?php
  $inputs = array("example.txt");
  // $inputs = array("example.txt", "input.txt");

  class History {
    public $initial_sequence;
    public $rows = array();
    public $generation_complete = false;
    private $current_row;

    function __construct($values) {
      $this->initial_sequence = $values;
      $this->current_row = $values;
      $this->rows[] = $values;
    }

    function generate_rows() {
      while(!$this->generation_complete) {
        $this->generation_complete = true;
        $this->generate_next_row();
      }
    }

    function generate_next_row() {
      $next_row = array();
      $numbers_to_generate = count($this->current_row) - 1;

      for($i = 0; $i < $numbers_to_generate; $i++) {
        // if(!array_key_exists($i + 1, $this->current_row)) {
        //   break;
        // }

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
      return;
    }

    echo $input . ": " . $result . "\n";
  }

  function process_sequence($line) {
    $result = 0;
    $nums = array_map('intval', explode(" ", $line));

    $history = new History($nums);

    $history->generate_rows();

    print_r($history->rows);

    return $result;
  }
?>
