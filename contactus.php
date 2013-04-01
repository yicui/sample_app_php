<?php
  session_start();
  if (!isset($_SESSION["course_num"])) {
    require_once("view/errorView.php");
    display_route_error("You haven't selected a course yet. Login first if you haven't done so.");
    return;
  }  
  if (!isset($_SESSION["role"]))
    $_SESSION["role"] = "visitor";

  $_SESSION["title"] = "Contact Us";
  require_once("header.php");  
  require_once("view/personView.php");  
  display_email($teacher['Email'], 'class="contactinfo"', '          ');
  display_portrait($teacher['PortraitURL'], $teacher['ThumbnailURL'], 'class="lightbox"', '          ');
  display_address($teacher['Office'], 'class="contactinfo"', '          ');
  display_map($teacher['Office'], 'id="map"', '          ');  
  include("view/footerView.php");
?>