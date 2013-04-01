<?php
  require_once("model/courseModel.php");
  require_once("model/teacherModel.php");
  require_once("view/accordionView.php");
  require_once("view/gridView.php");  
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

  function format_courses_in_grid($result) {
    $grid = array();
    for ($i = 0; $i < count($result); $i ++) {
      $griditem = array();
      $griditem["Tag"] = 'a';
      $griditem["Attributes"] = 'href="courses.php?action=selectcourse&coursenumber=' . $result[$i]["Number"] . '"';
      $griditem["Content"] = $result[$i]["Number"] . ': ' . $result[$i]["Title"];
      $grid[$i][0] = $griditem;
    }
    return $grid;
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

  if ($_SESSION["role"] == "visitor") {
    $_SESSION["title"] = "";  
    require_once("header.php");
    include("view/footerView.php");
  }
  else if (isset($_GET["action"])) {
    if ($_GET["action"] = "selectcourse") {
      $_SESSION["course_num"] = $_GET["coursenumber"];
      $_SESSION["title"] = $_SESSION["course_num"] . " is selected";
      require_once("header.php");
      include("view/footerView.php");
      return;
    }
    if ($_GET["action"] = "updateteacher")
      $form = format_update_teacher($_GET["coursenumber"]);
    display_form($form, "courses.php", "get", "");
  }
  else if (isset($_GET["coursenumber"]) && isset($_GET["teacheremail"])) {
    update_course($_GET["coursenumber"], $_GET["teacheremail"]);
    $_SESSION["title"] = "Successfully changed the teacher of " . $_GET["coursenumber"] . " to " . $_GET["teacheremail"];
    require_once("header.php");
    display_element('a', 'View Courses', 'href="courses.php"', '          ');
    include("view/footerView.php");
  }
  else {
    if ($_SESSION["role"] != "admin") {
      $_SESSION["title"] = "Select a Course";
      require_once("header.php");
      if ($_SESSION["role"] == "student")
        $result = get_courses_by_student($_SESSION["username"]);
      else
        $result = get_courses_by_teacher($_SESSION["username"]);
      $grid = format_courses_in_grid($result);
      display_grid($grid);
      include("view/footerView.php");
      return;
    }
    $_SESSION["title"] = "Courses";
    require_once("header.php");
    $result = get_courses();
    for ($i = 0; $i < count($result); $i ++) {
      $teacher = get_teacher($result[$i]["Number"]);
      if ($teacher == false) $result[$i]["TeacherEmail"] = "No teacher assigned";
      $result[$i]["TeacherEmail"] = $teacher["Email"];
    }
    $accordion = format_courses_in_accordion($result);
    display_accordion($accordion);
    include("view/footerView.php");
  }
?>