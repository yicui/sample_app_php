<?php
  require_once("elementView.php");
  function display_grid($grid, $indent = "") {
    echo $indent . '<ol class="grid">' . PHP_EOL;
    for ($i = 0; $i < count($grid); $i ++) {
      echo $indent . '  <li class="griditem ui-state-default">' . PHP_EOL;
      for ($j = 0; $j < count($grid[$i]); $j ++)
        display_composite_element($grid[$i][$j], $indent . '    ');
      echo $indent . '  </li>' . PHP_EOL;
    }
    echo $indent . '</ol>' . PHP_EOL;
  }
?>