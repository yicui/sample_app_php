<?php
          $course_num = 'CS292';  $title = "Syllabus";
          require_once("header.php");
          echo '         <p>' . $row['Syllabus'] . '</p>' . PHP_EOL;
          mysql_close($db);
          include("footer.php");
?>