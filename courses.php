<?php
  require_once("model/courseModel.php");
  require_once("model/teacherModel.php");
  require_once("view/accordionView.php");
  require_once("view/formView.php");

  function format_courses_in_accordion($result) {
    $accordion = array();
    for ($i = 0; $i < count($result); $i ++) {
      $accordion[$i]["Title"] = $result[$i]["Number"] . ': ' . $result[$i]["Title"];
      $accordioncontent = array();
      $accordioncontent["Tag"] = "span";
      $accordioncontent["Attributes"] = "";
      $accordioncontent["Content"] = "Lecturer Account: " . $result[$i]["TeacherEmail"];
      $accordion[$i]["Content"][0] = $accordioncontent;
      $accordioncontent = array();
      $accordioncontent["Tag"] = "a";
      $accordioncontent["Attributes"] = 'class="dialog" href="courses.php?action=updateteacher&coursenumber=' . $result[$i]["Number"] . '"';
      $accordioncontent["Content"] = "Change Lecturer";
      $accordion[$i]["Content"][1] = $accordioncontent;
    }
    return $accordion;
  }
  function format_update_teacher($course_num) {
    $input = array();
    $input[0]["prompt"] = "Course: ";
    $input[0]["name"] = "coursenumber";
    $input[0]["type"] = "text";
    $input[0]["value"] = $course_num;
    $input[1]["prompt"] = "Email: ";
    $input[1]["name"] = "teacheremail";
    $input[1]["type"] = "text";
    return $input;
  }

  session_start();
  if (!isset($_SESSION["role"]))
    $_SESSION["role"] = "visitor";
  if ($_SESSION["role"] != "admin") {
    display_route_error("You must be an admin to view this page");
    return;
  }

  if (isset($_GET["action"])) {
    if ($_GET["action"] = "updateteacher")
      $form = format_update_teacher($_GET["coursenumber"]);
    display_form($form, "courses.php", "get", "");
  }
  else if (isset($_GET["coursenumber"]) && isset($_GET["teacheremail"])) {
    update_course($_GET["coursenumber"], $_GET["teacheremail"]);
    $title = "Courses";
    require_once("header.php");
    display_element('p', 'Successfully changed the teacher of ' . $_GET["coursenumber"] . ' to ' . $_GET["teacheremail"], '', '          ');
    display_element('a', 'View Courses', 'href="courses.php"', '          ');
    include("view/footerView.php");
  }
  else {
    $title = "Courses";
    require_once("header.php");
    $result = get_courses();
    for ($i = 0; $i < count($result); $i ++) {
      $teacher = get_teacher($result[$i]["Number"]);
      if ($teacher == false) $result[$i]["TeacherEmail"] = "No teacher assigned";
      $result[$i]["TeacherEmail"] = $teacher["Email"];
    }
    $accordion = format_courses_in_accordion($result, $course_num);
    display_accordion($accordion);
    include("view/footerView.php");
  }
?>