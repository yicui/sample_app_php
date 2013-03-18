<?php
          $course_num = 'CS292';  $title = "Contact Us";
          require_once("header.php");
          echo '          <p class="contactinfo">Send me an <a href="mailto:' . $row['Email'] . '?subject=Hello">Email</a></p>' . PHP_EOL;
          echo '          <a class="lightbox" href="' . $row['PortraitURL'] . '" title="Full-size Portrait">' . PHP_EOL;
          echo '            <img src="' . $row['ThumbnailURL'] . '" alt="portrait"/>' . PHP_EOL;
          echo '          </a>' . PHP_EOL;
          echo '          <p class="contactinfo">My office is at ' . $row['Office'] . '</p>' . PHP_EOL;
          echo '          <img id="map" src="http://maps.googleapis.com/maps/api/staticmap?size=400x250&markers=address:' . $row['Office'] . '&maxZoom=17&sensor=false"/>' . PHP_EOL;
          mysql_close($db);
          include("footer.php");
?>