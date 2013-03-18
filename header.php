<?php
  require_once("model/courseModel.php");
  require_once("model/teacherModel.php");
  require_once("view/headerView.php");
  global $title;
  $course_num = "CS292";
  $course = get_course($course_num);
  display_metadata($course, $title);
  $teacher = get_teacher($course_num);
  display_header($course, $teacher);
  display_navigation();
  display_title($title);
?>
