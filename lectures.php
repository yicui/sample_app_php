<!DOCTYPE html>
<html>
  <head>
    <?php
      $db = mysql_connect("localhost", "root", "12345");
      mysql_select_db("teaching", $db);
      $course_num = 'CS292';
      $result = mysql_query('SELECT * from courses WHERE Number="' . $course_num . '"', $db);
      $row = mysql_fetch_array($result);
      echo PHP_EOL;
      echo '    <title>' . $row['Description'] . ': Lecture Notes ' . '</title>' . PHP_EOL;
      echo '    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>' . PHP_EOL;
      echo '    <meta name="keywords" content="' . $row['Description'] . ', lectures"/>' . PHP_EOL;
      echo '    <meta name="description" content="Lecture Notes of the ' . $row['Title'] . ' course"/>' . PHP_EOL;
    ?>
    <link rel="stylesheet" type="text/css" href="assets/style.css"/>
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/themes/base/jquery-ui.css"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="https://raw.github.com/jbdemonte/gmap3/master/gmap3.js"></script>
    <script type="text/javascript" src="assets/jquery.js"></script>
  </head>
  <body>
    <div id="container">
      <div id="header">
        <?php
          $result = mysql_query('SELECT * from courses, teachers WHERE teachers.ID=courses.TeacherID AND courses.Number="' . $course_num . '"', $db);
          $row = mysql_fetch_array($result);
          echo PHP_EOL;
          echo '        <h1>' . $row['Title'] . '</h1>' . PHP_EOL;
          echo '        <h3 title="Email: ' . $row['Email'] . '">Lecturer: ' . $row['FirstName'] . ' ' . $row['LastName'] . '</h3>' . PHP_EOL;
        ?>
        <h3 id="mobilenavigation"><a href="#navigation">Navigate</a></h3>
      </div>
      <div id="navigation">
        <ul>
          <li><a href="syllabus.php">Syllabus</a></li>
          <li><a href="lectures.php">Lecture Notes</a></li>
          <li><a href="assignments.php">Assignments</a></li>
        </ul>
      </div>
      <div id="content">
        <h2>Lecture Notes</h2>
        <div class="accordion">
          <?php
            $result = mysql_query('SELECT lecturenotes.* from courses, lecturenotes WHERE courses.ID=lecturenotes.courseID AND courses.Number="' . $course_num . '"', $db);
            echo PHP_EOL;
            while ($row = mysql_fetch_array($result)) {
              echo '          <h3>' . $row['Title'] . '</h3>' . PHP_EOL;
              echo '          <div>' . PHP_EOL;
              echo '            <p>' . $row['Content'] . '</p>' . PHP_EOL;
              echo '          </div>' . PHP_EOL;
            }
            mysql_close($db);
          ?>
        </div>
      </div>
      <div id="pushdown"></div>
    </div>
    <div id="footer">
      <a href="#">About</a> - <a href="contactus.php">Contact Us</a> - <a href="#">Terms of Use</a>
    </div>
  </body>
</html>