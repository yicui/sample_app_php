<?php
  $title = "Syllabus";
  require_once("header.php");
  require_once("view/elementView.php");
  display_element('p', $course['Syllabus'], '', '         ');
  include("view/footerView.php");
?>