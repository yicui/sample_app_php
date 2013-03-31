<?php
  require_once("database.php");
  function get_teacher($course_num) {
    $result = mysql_query('SELECT * from courses, teachers WHERE teachers.ID=courses.TeacherID AND courses.Number="' . mysql_real_escape_string($course_num) . '"');
    if (!$result)
      display_db_error("Cannot find teacher of the course " . mysql_real_escape_string($course_num));
    return mysql_fetch_array($result, 0);
  }

  function is_teacher_valid($email, $password) {
    $email = strtoupper($email);
    if (!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/", $email))
      display_input_error("Teacher email is invalid");

    $result = mysql_query("SELECT * from teachers WHERE Email = '". $email . "'");
    if (mysql_num_rows($result) == 0) return "Nonexisting teacher account " . $email;

    $row = mysql_fetch_array($result);
    if (sha1($email . mysql_real_escape_string($password)) != $row['Password']) return "Wrong Password";
    return "Welcome " . $row['FirstName'] . "!";
  }  
?>