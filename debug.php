<?php
  function echo_sql_table($result) {
    $output = "Echoing...<br/>";
    $current = mysqli_fetch_array($result, MYSQLI_NUM);
    while ($current != null) {
      foreach($current as $i=>$item) {
        $output .= "$item ";
      }
      $output .= "<br/>";
      $current = mysqli_fetch_array($result, MYSQLI_NUM);
    }
    echo("<p>$output</p>");
  }
?>