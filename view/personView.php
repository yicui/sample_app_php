<?php
  function display_email($email, $attributes = "", $indent = "") {
    echo $indent . '<p ' . $attributes . '>Send me an <a href="mailto:' . $email . '?subject=Hello">Email</a>' . '</p>' . PHP_EOL;
  }
  function display_portrait($portraitURL, $thumbnailURL, $attributes = "", $indent = "") {
    echo $indent . '<a ' . $attributes . ' href="' . $portraitURL . '" title="Full-size Portrait">' . PHP_EOL;
    echo $indent . '  <img src="' . $thumbnailURL . '" alt="portrait"/>' . PHP_EOL;
    echo $indent . '</a>' . PHP_EOL;
  }
  function display_address($address, $attributes = "", $indent = "") {
    echo $indent . '<p ' . $attributes . '>My office is ' . $address . '</p>' . PHP_EOL;
  }
  function display_map($address, $attributes = "", $indent = "") {
    echo $indent . '<img ' . $attributes . ' src="http://maps.googleapis.com/maps/api/staticmap?size=400x250&markers=address:' . $address . '&maxZoom=17&sensor=false"/>' . PHP_EOL;
  }
?>