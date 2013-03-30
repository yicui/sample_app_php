<?php
  require_once("model/studentModel.php");
  require_once("view/paginatorView.php");
  require_once("view/gridView.php");
  require_once("view/formView.php");

  function format_students_in_grid($result) {
    $grid = array();
    for ($i = 0; $i < count($result); $i ++) {
      $griditem = array();
      $griditem["Tag"] = 'a';
      $griditem["Attributes"] = 'class="lightbox" href="' . $result[$i]["PortraitURL"] . '" title="' . $result[$i]["FirstName"] . ' ' . $result[$i]["LastName"] . ' portrait"';
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

  function format_add_students() {
    $input = array();
    $input[0]["prompt"] = "Email: ";
    $input[0]["name"] = "email";
    $input[0]["type"] = "text";
    return $input;
  }

  if (isset($_GET["coursenumber"]) && isset($_GET["startingfrom"]) && isset($_GET["recordcount"])) {
    $result = get_students($_GET["coursenumber"], $_GET["startingfrom"], $_GET["recordcount"]);
    $grid = format_students_in_grid($result);
    display_grid($grid);
  }
  else if (isset($_GET["add"]) && $_GET["add"] == true) {
    $form = format_add_students();
    display_form($form, "students.php", "post", "");
  }
  else if (isset($_POST["email"])) {
    $title = "Students";
    require_once("header.php");
    $studentID = add_student($course_num, $_POST["email"]);
    display_element('p', 'Successfully added ' . $_POST["email"], '', '         ');
    display_element('a', 'View Students', 'href="students.php"', '         ');
    include("view/footerView.php");
  }
  else {
    $title = "Students";
    require_once("header.php");
    $result = get_students($course_num, 0, 5);
    $grid = format_students_in_grid($result, $course_num);
    display_loadmore_paginator("students.php?coursenumber=" . $course_num, "display_grid", $grid, "         ");
    display_element('a', 'Add a student', 'href="students.php?add=true" class="dialog"', '         ');
    include("view/footerView.php");
  }
?>