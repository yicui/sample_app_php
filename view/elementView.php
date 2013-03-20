<?php
  function display_element($tag, $content, $attributes = "", $indent = "") {
    echo $indent . '<' . $tag . ' ' . $attributes . '>' . $content . '</' . $tag . '>' . PHP_EOL;
  }
  function display_composite_element($element, $indent = "") {
    if (isset($element["Editinplace"])) {
      echo $indent . '<' . $element["Tag"] . ' class="editinplace">' . PHP_EOL;  
      echo $indent . '  <' . $element["Tag"] . '>' . $element["Content"] . '</' . $element["Tag"] . '>' . PHP_EOL;
      echo $indent . '  <input type="text" ' . $element["Attributes"] . '/><input type="button" value="Save" href="' . $element["Editinplace"] . '"/><input type="button" value="Cancel"/>' . PHP_EOL;
    }
    else echo $indent . '<' . $element["Tag"] . ' ' . $element["Attributes"] . '>' . $element["Content"] . PHP_EOL;
    if (isset($element["Children"]))
      for ($i = 0; $i < count($element["Children"]); $i ++)
        display_composite_element($element["Children"][$i], $indent . "  ");
    echo $indent . '</' . $element["Tag"] . '>' . PHP_EOL;  
  }
?>