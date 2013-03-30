<?php
  require_once('database.php');
  require_once('utils/thumbnail.php');
  function get_students_count($course_num) {
    $result = mysql_query("SELECT COUNT(*) from students, courses, study WHERE study.StudentID = students.ID AND study.CourseID = courses.ID AND courses.Number = '" . mysql_real_escape_string($course_num) . "'");
    return mysql_result($result, 0);
  }

  function get_students($course_num, $startingindex, $recordcount) {
    $options = array('options' => array('min_range' => 0), 'flags' => FILTER_FLAG_ALLOW_OCTAL,);
    filter_var($recordcount, FILTER_VALIDATE_INT, $options) or  display_input_error("invalid record count");
    if (!filter_var($startingindex, FILTER_VALIDATE_INT, $options) && $startingindex != 0) display_input_error("invalid starting index");

    $result = mysql_query("SELECT students.* from students, courses, study WHERE study.StudentID = students.ID AND study.CourseID = courses.ID AND courses.Number = '" . mysql_real_escape_string($course_num) . "' ORDER BY students.LastName LIMIT " . $startingindex . ", " . $recordcount);
    $records = array();
    while ($row = mysql_fetch_array($result))
       $records[] = $row;
    return $records;
  }

  function register_student($lastname, $firstname, $email, $password, $yearenrolled) {
    $email = strtoupper($email);
    preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/", $email) or display_input_error("Email is invalid");        
    preg_match("/^[0-9]{4}$/", $yearenrolled) or display_input_error("Enrolled year is invalid");
    preg_match("/^[A-Za-z]+$/", $lastname) or display_input_error("Last name is invalid");
    preg_match("/^[A-Za-z]+$/", $firstname) or display_input_error("First name is invalid");        
    $result = mysql_query("SELECT COUNT(*) from students WHERE students.Email = '". $email . "'");
    if (mysql_result($result, 0) > 0) display_input_error("Student account " . $email . " already exists!");

    mysql_query("INSERT INTO students (LastName, FirstName, Email, YearEnrolled) VALUES ('" . $lastname . "','" . $firstname . "','" . $email . "','" . $yearenrolled . "')");
    $result = mysql_query("SELECT students.ID from students WHERE students.Email = '". $email . "'");
    $studentID = mysql_result($result, 0);

    mysql_query("UPDATE students SET Password = '" . sha1($email . mysql_real_escape_string($password)) . "' WHERE ID = " . $studentID);
    return $studentID;
  }

  function update_student_picture($studentID, $file) {
    $type = strtolower(substr(strrchr($file["name"], "." ), 1));
    if (($type != "jpg") && ($type != "gif") && ($type != "png"))
        display_input_error("Uploaded picture has invalid format: " . $type);

    // We use Student.ID to index portrait & thumbnail files, such that there are no duplicate file names
    $portraitURL = "images/student" . $studentID . "." . $type;
    $thumbnailURL = "thumbnails/student" . $studentID . ".jpg";
    move_uploaded_file($file['tmp_name'], $portraitURL) or display_file_error("Failed to store the picture to " . $portraitURL);
    make_thumbnail($portraitURL, $thumbnailURL, 300, 400, 1);       

    $statement = "UPDATE students SET students.ThumbnailURL = '" . mysql_real_escape_string($thumbnailURL) . "', students.PortraitURL = '" . mysql_real_escape_string($portraitURL) . "' WHERE students.ID = '" . $studentID . "'";
    mysql_query($statement);
    if (mysql_affected_rows() == 0) display_db_error("Student ID " . $studentID . " does not exist");
  }
  
  function add_student($course_num, $email) {
    $email = strtoupper($email);
    if (!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/", $email)) 
      display_input_error("Student email is invalid");

    $result = mysql_query("SELECT ID from students WHERE Email = '". $email . "'");
    if (mysql_num_rows($result) == 0) return "Nonexisting student account " . $email;
    $studentID = mysql_result($result, 0);

    $result = mysql_query("SELECT courses.ID from courses WHERE courses.Number = '" . mysql_real_escape_string($course_num) . "'");
    $courseID = mysql_result($result, 0);

    mysql_query("INSERT INTO study (StudentID, CourseID) VALUES ('" . $studentID . "','" . $courseID . "')");
    return $studentID;
  }

  function is_student_valid($email, $password) {
    $email = strtoupper($email);
    if (!preg_match("/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/", $email))
      display_input_error("Student email is invalid");

    $result = mysql_query("SELECT * from students WHERE Email = '". $email . "'");
    if (mysql_num_rows($result) == 0) return "Nonexisting student account " . $email;

    $row = mysql_fetch_array($result);
    if (sha1($email . mysql_real_escape_string($password)) != $row['Password']) return "Wrong Password";
    return "Welcome " . $row['FirstName'] . "!";
  }
?>