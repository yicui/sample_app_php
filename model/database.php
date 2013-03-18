<?php
  include_once("view/errorView.php");
  global $course_num;
  $db = mysql_connect("localhost", "root", "12345");
  mysql_select_db("teaching", $db) or display_db_error("unable to connect to the database");
?>