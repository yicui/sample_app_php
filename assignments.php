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
      $accordioncontent["Attributes"] = 'class="datepicker"';
      $accordioncontent["Content"] = $result[$i]["DueDate"];
      $accordioncontent["Editinplace"] = "assignments.php?coursenumber=" . $course_num;
      $accordion[$i]["Content"][0] = $accordioncontent;
      $accordioncontent = array();
      $accordioncontent["Tag"] = "p";
      $accordioncontent["Attributes"] = "";
      $accordioncontent["Content"] = $result[$i]["Description"];
      $accordion[$i]["Content"][1] = $accordioncontent;  
    }
    return $accordion;
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
    $title = "Assignments";
    require_once("header.php");
    $result = get_assignments($course_num, 0, 2);
    $accordion = format_assignments_in_accordion($result, $course_num);
    display_loadmore_paginator("assignments.php?coursenumber=" . $course_num, "display_accordion", $accordion, "         ");
    include("view/footerView.php");  
  }
?>