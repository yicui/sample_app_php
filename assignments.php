<?php
          $title = "Assignments";
          require_once("header.php");
          echo '        <div class="accordion">' . PHP_EOL;
            $result = mysql_query('SELECT assignments.* from courses, assignments WHERE courses.ID=assignments.courseID AND courses.Number="' . $course_num . '" ORDER BY DueDate LIMIT 0, 2');
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
          echo '        </div>' . PHP_EOL;
          echo '        <h3><a class="loadmorepaginator" href="assignmentspaginator.php?coursenumber=' . $course_num . '">More</a></h3>' . PHP_EOL;
          include("footer.php");
?>