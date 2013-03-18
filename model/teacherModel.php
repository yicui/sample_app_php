<?php
  require_once("database.php");
  function get_teacher($course_num) {
    $result = mysql_query('SELECT * from courses, teachers WHERE teachers.ID=courses.TeacherID AND courses.Number="' . mysql_real_escape_string($course_num) . '"');
    if (!$result)
      display_db_error("Cannot find teacher of the course " . mysql_real_escape_string($course_num));
    return mysql_fetch_array($result, 0);
  }
?>