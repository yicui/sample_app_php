<?php
  require_once("model/assignmentModel.php");
  require_once("view/paginatorView.php");
  require_once("view/accordionView.php");
  
  function format_assignments_in_accordion($result, $course_num) {
    $accordion = array();
    for ($i = 0; $i < count($result); $i ++) {
      $accordion[$i]["Title"] = $result[$i]["Title"];
      $accordioncontent = array();
      $accordioncontent["Tag"] = "span";
      $accordioncontent["Content"] = $result[$i]["DueDate"];
      if ($_SESSION["role"] == "teacher") {
        $accordioncontent["Attributes"] = 'class="datepicker"';
        $accordioncontent["Editinplace"] = "assignments.php?coursenumber=" . $course_num;
      }
      else $accordioncontent["Attributes"] = "";
      $accordion[$i]["Content"][0] = $accordioncontent;
      $accordioncontent = array();
      $accordioncontent["Tag"] = "p";
      $accordioncontent["Attributes"] = "";
      $accordioncontent["Content"] = $result[$i]["Description"];
      $accordion[$i]["Content"][1] = $accordioncontent;  
    }
    return $accordion;
  }
  session_start();
  if (!isset($_SESSION["course_num"])) {
    header("Location: courses.php");
  }
  if (!isset($_SESSION["role"]))
    $_SESSION["role"] = "visitor";
  if ($_SESSION["role"] == "visitor") {
    display_route_error("You must be a teacher or student to view this page");
    return;
  }

  if (isset($_GET["coursenumber"]) && isset($_GET["startingfrom"]) && isset($_GET["recordcount"])) {
    $result = get_assignments($_GET["coursenumber"], $_GET["startingfrom"], $_GET["recordcount"]);
    $accordion = format_assignments_in_accordion($result, $_GET["coursenumber"]);
    display_accordion($accordion);  
  }
  else if (isset($_GET["coursenumber"]) && isset($_GET["assignmenttitle"]) && isset($_GET["duedate"])) {
    update_assignment($_GET["coursenumber"], $_GET["assignmenttitle"], $_GET["duedate"]);
  }
  else {
    $_SESSION["title"] = "Assignments";
    require_once("header.php");
    $count = get_assignments_count($_SESSION["course_num"]);
    display_tab_paginator("assignments.php?coursenumber=" . $_SESSION["course_num"] . "&", $count, 0, 2, "         ");
    include("view/footerView.php");  
  }
?>