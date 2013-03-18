<?php
  require_once("database.php");
  function get_course($course_num) {
    $result = mysql_query('SELECT * from courses WHERE Number="' . mysql_real_escape_string($course_num) . '"');
    if (!$result)
      display_db_error("The course " . mysql_real_escape_string($course_num) . "does not exist");
    return mysql_fetch_array($result, 0);
  }
?>