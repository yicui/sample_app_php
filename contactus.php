<?php
          $title = "Contact Us";
          require_once("header.php");
          echo '          <p class="contactinfo">Send me an <a href="mailto:' . $teacher['Email'] . '?subject=Hello">Email</a></p>' . PHP_EOL;
          echo '          <a class="lightbox" href="' . $teacher['PortraitURL'] . '" title="Full-size Portrait">' . PHP_EOL;
          echo '            <img src="' . $teacher['ThumbnailURL'] . '" alt="portrait"/>' . PHP_EOL;
          echo '          </a>' . PHP_EOL;
          echo '          <p class="contactinfo">My office is at ' . $teacher['Office'] . '</p>' . PHP_EOL;
          echo '          <img id="map" src="http://maps.googleapis.com/maps/api/staticmap?size=400x250&markers=address:' . $teacher['Office'] . '&maxZoom=17&sensor=false"/>' . PHP_EOL;
          include("view/footerView.php");
?>