<?php   
  function display_form($input, $url, $method, $indent = "") {
    echo $indent . '<form method="' . $method . '" enctype="multipart/form-data" action="' . $url . '">' . PHP_EOL;

    for ($i = 0; $i < count($input); $i ++) {
      if (!isset($input[$i]["name"]) || !isset($input[$i]["type"]) || !isset($input[$i]["prompt"]))
        continue;
      echo $indent . '  <label>' . $input[$i]["prompt"] . '</label>' . PHP_EOL;
      if (isset($input[$i]["value"]))
        echo $indent . '  <input type="' . $input[$i]["type"] . '" name="' . $input[$i]["name"] . '" value="' . $input[$i]["value"] . '"/>' . PHP_EOL;
      else echo $indent . '  <input type="' . $input[$i]["type"] . '" name="' . $input[$i]["name"] . '"/>' . PHP_EOL;
      echo $indent . '  <br/>' . PHP_EOL;
    }
    echo $indent . '  <div></div>' . PHP_EOL;
    echo $indent . '  <input type="submit" value="Submit"/>' . PHP_EOL;
    echo $indent . '</form>' . PHP_EOL;
  }
?>