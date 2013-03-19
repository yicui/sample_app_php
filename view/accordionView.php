<?php
  require_once("elementView.php");
  function display_accordion($accordion, $indent = "") {
    echo $indent . '<div class="accordion">' . PHP_EOL;
    for ($i = 0; $i < count($accordion); $i ++) {
      echo $indent . '  <h3>' . $accordion[$i]["Title"] . '</h3>' . PHP_EOL;
      echo $indent . '  <div>' . PHP_EOL;
      for ($j = 0; $j < count($accordion[$i]["Content"]); $j ++)
        display_composite_element($accordion[$i]["Content"][$j], $indent . '    ');
      echo $indent . '  </div>' . PHP_EOL;
    }
    echo $indent . '</div>' . PHP_EOL;
  }
?>