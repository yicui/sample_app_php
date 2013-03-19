<?php
  function display_tab_paginator($url, $numitems, $startingfrom, $recordcount, $indent = "") {
    echo $indent . '<div class="tabpaginator">' . PHP_EOL;
    echo $indent . '  <ul><li><a href="' . $url. '">Prev</a></li>' . PHP_EOL;
    $page = (int)$startingfrom/$recordcount + 1;
    while ($numitems > 0) {
      echo $indent . '    <li><a href="'. $url . 'startingfrom=' . $startingfrom . '&recordcount=' . $recordcount . '">' . $page . '</a></li>' . PHP_EOL;
      $page ++;  $startingfrom += $recordcount;    $numitems -= $recordcount;
    }
    echo $indent . '  <li><a href="' . $url. '">Next</a></li></ul>' . PHP_EOL;
    echo $indent . '</div>' . PHP_EOL;
  }
?>