<?php
  require_once("model/studentModel.php");
  require_once("model/teacherModel.php");
  require_once("view/formView.php");

  function format_login() {
    $input = array();
    $input[0]["prompt"] = "Email: ";
    $input[0]["name"] = "email";
    $input[0]["type"] = "text";
    $input[1]["prompt"] = "Password: ";
    $input[1]["name"] = "password";
    $input[1]["type"] = "password";
    return $input;
  }
  function format_registration() {
    $input = array();
    $input[0]["prompt"] = "First Name: ";
    $input[0]["name"] = "firstname";
    $input[0]["type"] = "text";          
    $input[1]["prompt"] = "Last Name: ";
    $input[1]["name"] = "lastname";
    $input[1]["type"] = "text";
    $input[2]["prompt"] = "Email: ";
    $input[2]["name"] = "email";
    $input[2]["type"] = "text";
    $input[3]["prompt"] = "Password: ";
    $input[3]["name"] = "password1";
    $input[3]["type"] = "password";
    $input[4]["prompt"] = "Retype it: ";
    $input[4]["name"] = "password2";
    $input[4]["type"] = "password";
    $input[5]["prompt"] = "Upload Picture: ";
    $input[5]["name"] = "portrait";
    $input[5]["type"] = "file";
    return $input;
  }
  // process login
  if (isset($_POST["email"]) && isset($_POST["password"])) {
    $response = is_student_valid($_POST["email"], $_POST["password"]);
    $title = $response;
    require_once("header.php");
    include("view/footerView.php");
  }
  // process registration
  else if (isset($_POST["lastname"]) && isset($_POST["firstname"]) && isset($_POST["email"]) && isset($_POST["password1"]) && isset($_POST["password2"]) && isset($_FILES["portrait"])) {
    if ($_POST["password1"] != $_POST["password2"])
      display_input_error("Retyped password doesn't match");
    $studentID = register_student($_POST["lastname"], $_POST["firstname"], $_POST["email"], $_POST["password1"], date("Y"));
    update_student_picture($studentID, $_FILES["portrait"]);
    $title = "Registration Completed";
    require_once("header.php");
    include("view/footerView.php");
  }
  else if (isset($_GET["action"])) {
    if ($_GET["action"] == "login")
      $form = format_login();
    else if ($_GET["action"] == "register")
      $form = format_registration();
    display_form($form, "login.php", "post", "");
  }
?>
