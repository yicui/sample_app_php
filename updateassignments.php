<?php
  $assignmenttitle = mysql_real_escape_string($_GET["assignmenttitle"]);
  $duedate = $_GET["duedate"];
  preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $duedate, $parts) or die("Please follow the yyyy-mm-dd format");
  checkdate($parts[2], $parts[3], $parts[1]) or die("Invalid date, please try again");
  $course_num = $_GET["coursenumber"];

  $statement = "UPDATE assignments, courses SET assignments.DueDate = '" . $duedate . "' WHERE assignments.CourseID = courses.ID AND courses.Number = '". $course_num . "' AND assignments.Title = '" . $assignmenttitle . "'";
  if (mysql_query($statement) == FALSE) 
    echo "The assignment " . $assignmenttitle . "does not exist";
  echo $duedate;
?>
