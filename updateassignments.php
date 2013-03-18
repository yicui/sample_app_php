<?php
  require_once("model/database.php");  

  $assignmenttitle = mysql_real_escape_string($_GET["assignmenttitle"]);
  $duedate = $_GET["duedate"];
  preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $duedate, $parts) or display_input_error("invalid date format, the correct format is yyyy-mm-dd");
  checkdate($parts[2], $parts[3], $parts[1]) or display_input_error("invalid date");
  $course_num = $_GET["coursenumber"];

  $statement = "UPDATE assignments, courses SET assignments.DueDate = '" . $duedate . "' WHERE assignments.CourseID = courses.ID AND courses.Number = '". $course_num . "' AND assignments.Title = '" . $assignmenttitle . "'";
  if (mysql_query($statement) == FALSE) 
    display_db_error("The assignment " . $assignmenttitle . "does not exist");
  echo $duedate;
?>
