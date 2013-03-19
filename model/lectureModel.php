<?php
  require_once('database.php');
  function get_lectures_count($course_num) {
    $result = mysql_query('SELECT COUNT(*) from courses, lecturenotes WHERE courses.ID=lecturenotes.courseID AND courses.Number="' . mysql_real_escape_string($course_num) . '"');
    return mysql_result($result, 0);
  }

  function get_lectures($course_num, $startingindex, $recordcount) {
    $options = array('options' => array('min_range' => 0), 'flags' => FILTER_FLAG_ALLOW_OCTAL,);
    filter_var($recordcount, FILTER_VALIDATE_INT, $options) or  display_input_error("invalid record count");
    if (!filter_var($startingindex, FILTER_VALIDATE_INT, $options) && $startingindex != 0) display_input_error("invalid starting index");

    $result = mysql_query("SELECT lecturenotes.* from lectureNotes, courses WHERE lecturenotes.CourseID = courses.ID AND courses.Number = '" . mysql_real_escape_string($course_num) . "' LIMIT " . $startingindex . ", " . $recordcount);
    $records = array();
    while ($row = mysql_fetch_array($result))
      $records[] = $row;
    return $records;
  }
?>