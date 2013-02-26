<?php
  $assignmenttitle = $_GET["assignmenttitle"];
  $duedate = $_GET["duedate"];
  $course_num = $_GET["coursenumber"];
  $db = mysql_connect("localhost", "root", "12345");
  mysql_select_db("teaching", $db) or die("Database Error");
  $statement = "UPDATE assignments, courses SET assignments.DueDate = '" . $duedate . "' WHERE assignments.CourseID = courses.ID AND courses.Number = '". $course_num . "' AND assignments.Title = '" . $assignmenttitle . "'";
  if (mysql_query($statement) == FALSE) 
    die("Database Error");
  mysql_close($db);
  echo $duedate;
?>
