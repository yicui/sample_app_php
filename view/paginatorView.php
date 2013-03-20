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

  function display_loadmore_paginator($url, $display_method, $initial_load, $indent = "") {
    call_user_func($display_method, $initial_load, $indent);
    echo $indent . '<h3><a class="loadmorepaginator" href="' . $url . '">More</a></h3>' . PHP_EOL;
  }  
?>