<?php
  require_once('database.php');
  function get_assignments_count($course_num) {
    $result = mysql_query("SELECT assignments.* from courses, assignments WHERE assignments.CourseID = courses.ID AND courses.Number = '" . mysql_real_escape_string($course_num) . "'");
    return mysql_result($result, 0);
  }

  function get_assignments($course_num, $startingindex, $recordcount) {
    $options = array('options' => array('min_range' => 0), 'flags' => FILTER_FLAG_ALLOW_OCTAL,);
    filter_var($recordcount, FILTER_VALIDATE_INT, $options) or  display_input_error("invalid record count");
    if (!filter_var($startingindex, FILTER_VALIDATE_INT, $options) && $startingindex != 0) display_input_error("invalid starting index");

    $result = mysql_query("SELECT assignments.* from courses, assignments WHERE assignments.CourseID = courses.ID AND courses.Number = '" . mysql_real_escape_string($course_num) . "' ORDER BY assignments.DueDate LIMIT " . $startingindex . ", " . $recordcount);
    $records = array();
    while ($row = mysql_fetch_array($result)) 
      $records[] = $row;
    return $records;
  }

  function update_assignment($course_num, $assignmenttitle, $duedate) {
    preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $duedate, $parts) or display_input_error("Please follow the yyyy-mm-dd format");
    checkdate($parts[2], $parts[3], $parts[1]) or display_input_error("Invalid date, please try again");

    $statement = "UPDATE courses, assignments SET assignments.DueDate = '" . $duedate . "' WHERE assignments.CourseID = courses.ID AND courses.Number = '" . mysql_real_escape_string($course_num) . "' AND assignments.Title = '" . mysql_real_escape_string($assignmenttitle) . "'";
    if (mysql_query($statement) == FALSE) display_db_error("The assignment " . mysql_real_escape_string($assignmenttitle) . "does not exist");
    echo $duedate;
  }
?>