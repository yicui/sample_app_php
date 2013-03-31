<?php
  session_start();
  if (!isset($_SESSION["role"]))
    $_SESSION["role"] = "visitor";

  $title = "Syllabus";
  require_once("header.php");
  require_once("view/elementView.php");
  display_element('p', $course['Syllabus'], '', '         ');
  include("view/footerView.php");
?>