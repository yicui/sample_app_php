<?php
  require_once("model/courseModel.php");
  require_once("model/teacherModel.php");
  require_once("view/headerView.php");
  
  if (isset($_SESSION["course_num"])) {
    $course = get_course($_SESSION["course_num"]);
    $teacher = get_teacher($_SESSION["course_num"]);
  }
  else {
    $course = $teacher = null;
  }
  if (isset($_SESSION["username"]))
    $username = $_SESSION["username"];
  else $username = null;

  display_metadata($course, $_SESSION["title"]);
  display_header($course, $teacher, $_SESSION["role"], $username);
  display_navigation($_SESSION["role"], $course);
  display_title($_SESSION["title"]);
?>