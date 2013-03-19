<?php
  require_once("model/lectureModel.php");
  require_once("view/paginatorView.php");
  require_once("view/accordionView.php");

  function format_lectures_in_accordion($result) {
    $accordion = array();
    for ($i = 0; $i < count($result); $i ++) {
      $accordion[$i]["Title"] = $result[$i]["Title"];
      $accordioncontent = array();
      $accordioncontent["Tag"] = "p";
      $accordioncontent["Attributes"] = "";
      $accordioncontent["Content"] = $result[$i]["Content"];
      $accordion[$i]["Content"][0] = $accordioncontent;
    }
    return $accordion;
  }

  if (isset($_GET["coursenumber"]) && isset($_GET["startingfrom"]) && isset($_GET["recordcount"])) {
    $result = get_lectures($_GET["coursenumber"], $_GET["startingfrom"], $_GET["recordcount"]);
    $accordion = format_lectures_in_accordion($result);
    display_accordion($accordion);
  }
  else {
    $title = "Lecture Notes";
    require_once("header.php");
    $count = get_lectures_count($course_num);
    display_tab_paginator("lectures.php?coursenumber=" . $course_num . "&", $count, 0, 5, "         ");
    include("view/footerView.php");
  }
?>