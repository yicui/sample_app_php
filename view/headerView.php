<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="assets/style.css"/>
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/themes/base/jquery-ui.css"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="https://raw.github.com/jbdemonte/gmap3/master/gmap3.js"></script>
    <script type="text/javascript" src="assets/jquery.js"></script>
    <?php
      function display_metadata($course, $title) {
        if ($course == null) {
          echo PHP_EOL . '  </head>' . PHP_EOL;
          return;
        }
        echo PHP_EOL;
        echo '    <title>' . $course['Number'] . ': ' . $title . '</title>' . PHP_EOL;
        echo '    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>' . PHP_EOL;
        echo '    <meta name="keywords" content="' . $course['Description'] . ', lectures"/>' . PHP_EOL;
        echo '    <meta name="description" content="' . $title . ' of the ' . $course['Title'] . ' course"/>' . PHP_EOL;
        echo '  </head>' . PHP_EOL;
      }
      function display_header($course, $teacher, $role, $username) {
        echo '  <body>' . PHP_EOL;
        echo '    <div id="container">' . PHP_EOL;
        echo '      <div id="header">' . PHP_EOL;
        if ($course != null)
          echo '        <h1>' . $course['Title'] . '</h1>' . PHP_EOL;
        else echo '        <h1>Please Login to Select a Course</h1>' . PHP_EOL;
        if ($teacher != null)
          echo '        <h3 title="Email: ' . $teacher['Email'] . '">Lecturer: ' . $teacher['FirstName'] . ' ' . $teacher['LastName'] . '</h3>' . PHP_EOL;
        if ($role == "visitor")
          echo '        <h3><a href="login.php?action=login" class="dialog">Login</a> <a href="login.php?action=register" class="dialog">Register</a></h3>' . PHP_EOL;
        else echo '        <h3><a href="login.php?action=logout">Logout</a> ' . $username . '</h3>' . PHP_EOL;
        echo '        <h3 id="mobilenavigation"><a href="#navigation">Navigate</a></h3>' . PHP_EOL;
        echo '      </div>' . PHP_EOL;
      }
      function display_navigation($role, $course) {
        echo '      <div id="navigation">' . PHP_EOL;
        echo '        <ul>' . PHP_EOL;
        echo '          <li><a href="courses.php">Course Selection</a></li>' . PHP_EOL;
        if ($course != null) {
          echo '          <li><a href="syllabus.php">Syllabus</a></li>' . PHP_EOL;
          if ($role != "visitor") {
          echo '          <li><a href="lectures.php">Lecture Notes</a></li>' . PHP_EOL;
          echo '          <li><a href="assignments.php">Assignments</a></li>' . PHP_EOL;
          }
          if ($role == "teacher" || $role == "admin")
            echo '          <li><a href="students.php">Students</a></li>' . PHP_EOL;
        }
        echo '        </ul>' . PHP_EOL;
        echo '      </div>' . PHP_EOL;
      }
      function display_title($title) {
        echo '      <div id="content">' . PHP_EOL;
        if ($title == null) return;
        echo '        <h2>' . $title . '</h2>' . PHP_EOL;
      }
    ?>