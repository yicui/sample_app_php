<?php
  function display_element($tag, $content, $attributes = "", $indent = "") {
    echo $indent . '<' . $tag . ' ' . $attributes . '>' . $content . '</' . $tag . '>' . PHP_EOL;
  }
?>