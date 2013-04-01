<?php
  require_once('database.php');
  function is_admin_valid($email, $password) {
    $email = strtoupper($email);
    if (!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/", strtoupper($email)))
      display_input_error("Admin email is invalid");

    $result = mysql_query("SELECT * from admin WHERE Email = '". $email . "'");
      if (mysql_num_rows($result) == 0) return "Nonexisting admin account " . $email;

    $row = mysql_fetch_array($result);
    if (sha1($email . mysql_real_escape_string($password)) != $row['Password']) return "Wrong Password!";
    return "Welcome Admin!";
  }
?>