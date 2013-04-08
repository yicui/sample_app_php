<?php
  require_once("model/studentModel.php");
  require_once("model/teacherModel.php");
  require_once("model/adminModel.php");
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

  session_start();
  if (!isset($_SESSION["role"]))
    $_SESSION["role"] = "visitor";

  if (!isset($_SERVER['HTTPS'])) {
    $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: " . $url);
  }
  // process login
  if (isset($_POST["email"]) && isset($_POST["password"])) {
    if ($_SESSION["role"] != "visitor")
      display_route_error("You must first logout, then login again");  
    $response = is_student_valid($_POST["email"], $_POST["password"]);
    if (strstr($response, "Nonexisting student account") == true) {
      $response = is_teacher_valid($_POST["email"], $_POST["password"]);
      if (strstr($response, "Nonexisting teacher account") == true) {
        $response = is_admin_valid($_POST["email"], $_POST["password"]);
        if (strstr($response, "Nonexisting admin account") == true)
          $response = "Nonexisting account";
        else
          $_SESSION["role"] = "admin";
      }
      else $_SESSION["role"] = "teacher";
    }
    else $_SESSION["role"] = "student";
    if (strstr($response, "Wrong Password") == true)
      $_SESSION["role"] = "visitor";
    else $_SESSION["username"] = $_POST["email"];
    $_SESSION["title"] = $response;
    require_once("header.php");
    include("view/footerView.php");
  }
  // process registration
  else if (isset($_POST["lastname"]) && isset($_POST["firstname"]) && isset($_POST["email"]) && isset($_POST["password1"]) && isset($_POST["password2"]) && isset($_FILES["portrait"])) {
    if ($_POST["password1"] != $_POST["password2"])
      display_input_error("Retyped password doesn't match");
    $record = register_student($_POST["lastname"], $_POST["firstname"], $_POST["email"], $_POST["password1"], date("Y"));
    update_student_picture($record["ID"], $_FILES["portrait"]);
    $message = 'http://' . $_SERVER['HTTP_HOST'] . "/login.php?activationkey=" . $record["ActivationKey"] . "&email=" . $_POST["email"];
    mail($_POST["email"], "Activate your account", $message);
    $_SESSION["title"] = "Registration Completed. An activation email has been sent to " . $_POST["email"];
    require_once("header.php");
    include("view/footerView.php");
  }
  // process activation
  else if (isset($_GET["activationkey"]) && isset($_GET["email"])) {
    $response = activate_student($_GET["email"], $_GET["activationkey"]);
    // Whether success or failure, the role should be changed to visitor to allow the user to login or register
    $_SESSION["role"] = "visitor";
    $_SESSION["title"] = $response;
    require_once("header.php");
    include("view/footerView.php");
  }
  else if (isset($_GET["action"])) {
    if ($_GET["action"] == "logout") {
      $_SESSION["role"] = "visitor";
      $_SESSION["title"] = "You're now logged out";
      unset($_SESSION["course_num"]);
      require_once("header.php");
      include("view/footerView.php");
      return;
    }
    if ($_GET["action"] == "login") {
      if ($_SESSION["role"] != "visitor")
        display_route_error("You must first logout, then login again");
      $form = format_login();
    }
    else if ($_GET["action"] == "register")
      $form = format_registration();
    display_form($form, "login.php", "post", "");
  }
?>