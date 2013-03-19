<?php
  function display_element($tag, $content, $attributes = "", $indent = "") {
    echo $indent . '<' . $tag . ' ' . $attributes . '>' . $content . '</' . $tag . '>' . PHP_EOL;
  }
  function display_composite_element($element, $indent = "") {
    echo $indent . '<' . $element["Tag"] . ' ' . $element["Attributes"] . '>' . $element["Content"] . PHP_EOL;
    if (isset($element["Children"]))
      for ($i = 0; $i < count($element["Children"]); $i ++)
        display_composite_element($element["Children"][$i], $indent . "  ");
    echo $indent . '</' . $element["Tag"] . '>' . PHP_EOL;  
  }
?>