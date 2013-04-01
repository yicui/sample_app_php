<?php

  session_start();
  if (!isset($_SESSION["course_num"])) {
    require_once("view/errorView.php");
    display_route_error("You haven't selected a course yet. Login first if you haven't done so.");
    return;
  }
  if (!isset($_SESSION["role"]))
    $_SESSION["role"] = "visitor";

  $_SESSION["title"] = "Syllabus";
  require_once("header.php");  
  require_once("view/elementView.php");
  display_element('p', $course['Syllabus'], '', '         ');
  include("view/footerView.php");
?>