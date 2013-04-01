<?php
  require_once("model/lectureModel.php");
  require_once("view/paginatorView.php");
  require_once("view/accordionView.php");
  require_once("view/gridView.php");

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

  function format_lectures_in_grid($result) {
    $grid = array();
    for ($i = 0; $i < count($result); $i ++) {
      $griditem = array();
      $griditem["Tag"] = "h3";
      $griditem["Attributes"] = "";
      $griditem["Content"] = $result[$i]["Title"];
      $grid[$i][0] = $griditem;
      $griditem = array();
      $griditem["Tag"] = "p";
      $griditem["Attributes"] = "";
      $griditem["Content"] = $result[$i]["Content"];
      $grid[$i][1] = $griditem;
    }
    return $grid;
  }

  session_start();
  if (!isset($_SESSION["course_num"])) {
    display_route_error("You haven't selected a course yet. Login first if you haven't done so.");
    return;
  }
  if (!isset($_SESSION["role"]))
    $_SESSION["role"] = "visitor";
  if ($_SESSION["role"] == "visitor") {
    display_route_error("You must be a teacher or student to view this page");
    return;
  }

  if (isset($_GET["coursenumber"]) && isset($_GET["startingfrom"]) && isset($_GET["recordcount"])) {
    $result = get_lectures($_GET["coursenumber"], $_GET["startingfrom"], $_GET["recordcount"]);
    $grid = format_lectures_in_grid($result);
    display_grid($grid);
  }
  else {
    $_SESSION["title"] = "Lecture Notes";
    require_once("header.php");
    $result = get_lectures($_SESSION["course_num"], 0, 5);
    $grid = format_lectures_in_grid($result, $_SESSION["course_num"]);
    display_loadmore_paginator("lectures.php?coursenumber=" . $_SESSION["course_num"], "display_grid", $grid, "         ");
    include("view/footerView.php");
  }
?>