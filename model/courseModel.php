<?php
  require_once("database.php");
  function get_courses() {
    $result = mysql_query("SELECT * from courses");
    $records = array();
    while ($row = mysql_fetch_array($result))
      $records[] = $row;
    return $records;
  }

  function get_courses_by_teacher($email) {
    $email = strtoupper($email);
    if (!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/", $email))
      display_input_error("Teacher email is invalid");
  
    $result = mysql_query('SELECT courses.* from courses, teachers WHERE teachers.ID=courses.TeacherID AND teachers.Email="' . $email . '"');
    $records = array();
    while ($row = mysql_fetch_array($result))
      $records[] = $row;
    return $records;
  }

  function get_courses_by_student($email) {
    $email = strtoupper($email);
    if (!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/", $email))
      display_input_error("Student email is invalid");
  
    $result = mysql_query('SELECT courses.* from courses, students, study WHERE courses.ID=study.CourseID AND study.StudentID=students.ID AND students.Email="' . $email . '"');
    $records = array();
    while ($row = mysql_fetch_array($result))
      $records[] = $row;
    return $records;
  }

  function get_course($course_num) {
    $result = mysql_query('SELECT * from courses WHERE Number="' . mysql_real_escape_string($course_num) . '"');
    if (!$result)
      display_db_error("The course " . mysql_real_escape_string($course_num) . "does not exist");
    return mysql_fetch_array($result, 0);
  }

  function update_course($course_num, $email) {
    preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/", strtoupper($email)) or display_input_error("Email is invalid");

    $teacherID = "SELECT ID ";
    $result = mysql_query("SELECT ID from teachers WHERE Email = '". $email . "'");
    if (mysql_num_rows($result) == 0) display_input_error("Nonexisting teacher account " . $email);
    $teacherID = mysql_result($result, 0);

    $statement = "UPDATE courses, teachers SET courses.TeacherID = '" . $teacherID . "' WHERE courses.Number = '" . mysql_real_escape_string($course_num) . "'";
    if (mysql_query($statement) == FALSE) display_db_error("The course " . mysql_real_escape_string($course_num) . "does not exist");
    return $email;
  }  
?>