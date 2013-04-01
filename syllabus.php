<?php
  session_start();
  if (!isset($_SESSION["course_num"])) {
    header("Location: courses.php");
  }
  if (!isset($_SESSION["role"]))
    $_SESSION["role"] = "visitor";

  $_SESSION["title"] = "Syllabus";
  require_once("header.php");
  require_once("view/elementView.php");
  display_element('p', $course['Syllabus'], '', '         ');
  include("view/footerView.php");
?>