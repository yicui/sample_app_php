<?php
  require_once("model/database.php");

  $options = array('options' => array('min_range' => 0), 'flags' => FILTER_FLAG_ALLOW_OCTAL,);
  $startingindex = $_GET["startingfrom"];
  $recordcount = $_GET["recordcount"];
  $course_num = $_GET["coursenumber"];  
  filter_var($recordcount, FILTER_VALIDATE_INT, $options) or  display_input_error("invalid record count");
  if (!filter_var($startingindex, FILTER_VALIDATE_INT, $options) && $startingindex != 0) display_input_error("invalid starting index");

  $result = mysql_query("SELECT lecturenotes.* from lectureNotes, courses WHERE lecturenotes.CourseID = courses.ID AND courses.Number = '" . $course_num . "' LIMIT " . $startingindex . ", " . $recordcount);
  echo '<div class="accordion">' . PHP_EOL;
  while ($row = mysql_fetch_array($result)) {
    echo '<h3>' . $row['Title'] . '</h3>' . PHP_EOL;
    echo '<div' . PHP_EOL;
    echo '<p>' . $row['Content'] . '</p>' . PHP_EOL;
    echo '</div>' . PHP_EOL;
  }
  echo '</div>';
?>