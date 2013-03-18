<?php
            $course_num = 'CS292';  $title = "Lecture Notes";
            require_once("header.php");
            echo '        <div class="tabpaginator">' . PHP_EOL;
            $result = mysql_query('SELECT COUNT(*) from courses, lecturenotes WHERE courses.ID=lecturenotes.courseID AND courses.Number="' . $course_num . '"', $db);
            $count = mysql_result($result, 0);
            $page = 1;  $startingfrom = 0;  $recordcount = 5;
            echo '          <ul><li><a href="#">Prev</a></li>' . PHP_EOL;
            while ($count > $startingfrom) {
              echo '            <li><a href="lecturespaginator.php?startingfrom=' . $startingfrom . '&recordcount=' . $recordcount . '">' . $page . '</a></li>' . PHP_EOL;
              $page ++;  $startingfrom += $recordcount;
            }
            echo '          <li><a href="#">Next</a></li></ul>' . PHP_EOL;
            mysql_close($db);
            include("footer.php");
?>