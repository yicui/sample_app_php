<?php
  require_once("model/studentModel.php");
  require_once("view/paginatorView.php");
  require_once("view/gridView.php");

  function format_students_in_grid($result) {
    $grid = array();
    for ($i = 0; $i < count($result); $i ++) {
      $griditem = array();
      $griditem["Tag"] = 'a';
      $griditem["Attributes"] = 'class="lightbox" href="' . $result[$i]["PortraitURL"] . '" title="' . $result[$i]["PortraitURL"] . '"';
      $griditem["Content"] = '';
      $childitem = array();
      $childitem["Tag"] = 'img';
      $childitem["Attributes"] = 'alt="' . $result[$i]["FirstName"] . ' ' . $result[$i]["LastName"] . ' portrait" src="'. $result[$i]["ThumbnailURL"] . '"';
      $childitem["Content"] = "";
      $griditem["Children"][0] = $childitem;
      $grid[$i][0] = $griditem;
      $griditem = array();
      $griditem["Tag"] = "p";
      $griditem["Attributes"] = "";
      $griditem["Content"] = $result[$i]["FirstName"] . ' ' . $result[$i]["LastName"] . ' ' . $result[$i]["Email"];
      $grid[$i][1] = $griditem;
    }
    return $grid;
  }

  if (isset($_GET["coursenumber"]) && isset($_GET["startingfrom"]) && isset($_GET["recordcount"])) {
    $result = get_students($_GET["coursenumber"], $_GET["startingfrom"], $_GET["recordcount"]);
    $grid = format_students_in_grid($result);
    display_grid($grid);
  }
  else {
    $title = "Students";
    require_once("header.php");
    $result = get_students($course_num, 0, 2);
    $grid = format_students_in_grid($result, $course_num);
    display_loadmore_paginator("students.php?coursenumber=" . $course_num, "display_grid", $grid, "         ");
    include("view/footerView.php");
  }
?>