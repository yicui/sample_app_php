<?php
  $options = array('options' => array('min_range' => 0), 'flags' => FILTER_FLAG_ALLOW_OCTAL);
  $startingindex = $_GET["startingfrom"]; 
  $recordcount = $_GET["recordcount"];
  $course_num = $_GET["coursenumber"];
  filter_var($startingindex, FILTER_VALIDATE_INT, $options) or die();
  filter_var($recordcount, FILTER_VALIDATE_INT, $options) or die();
  $db = mysql_connect("localhost", "root", "12345");
  mysql_select_db("teaching", $db) or die();
  $result = mysql_query("SELECT assignments.* from assignments, courses WHERE assignments.CourseID = courses.ID AND courses.Number = '" . $course_num . "' ORDER BY assignments.DueDate LIMIT " . $startingindex . ", " . $recordcount);
  echo PHP_EOL;
  while ($row = mysql_fetch_array($result)) {
    echo '          <h3>' . $row['Title'] . '</h3>' . PHP_EOL;
    echo '          <div>' . PHP_EOL;
    echo '            <h5>Due Date' . PHP_EOL;
    echo '              <span class="editinplace">' . PHP_EOL;
    echo '                <span>' . $row['DueDate'] . '</span>' . PHP_EOL;
    echo '                <input type="text" class="datepicker"/><input type="button" value="Save" href="updateassignments.php?coursenumber=' . $course_num . '"/><input type="button" value="Cancel"/>' . PHP_EOL;
    echo '              </span>' . PHP_EOL;
    echo '            </h5>' . PHP_EOL;
    echo '            <p>' . $row['Description'] . '</p>' . PHP_EOL;
    echo '          </div>' . PHP_EOL;
  }
  mysql_close($db);
?>