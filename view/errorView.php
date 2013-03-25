<?php
  function display_db_error($error_message) {
    echo '<div>' . PHP_EOL;
    echo '  <h1>Database Error</h1>' . PHP_EOL;
    echo '  <p>Error message: ' . $error_message . '</p>' . PHP_EOL;
    echo '</div>' . PHP_EOL;
    die();
  }
  function display_input_error($error_message) {
    echo '<div>' . PHP_EOL;
    echo '  <h1>Input Error</h1>' . PHP_EOL;
    echo '  <p>Error message: ' . $error_message . '</p>' . PHP_EOL;
    echo '</div>' . PHP_EOL;
    die();
  }
  function display_file_error($error_message) {
    echo '<div>' . PHP_EOL;
    echo '  <h1>File IO Error</h1>' . PHP_EOL;
    echo '  <p>Error message: ' . $error_message . '</p>' . PHP_EOL;
    echo '</div>' . PHP_EOL;
    die();
  }  
?>