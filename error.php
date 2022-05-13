<?php
  function echo_error($errors, $origin) {
    echo("
      <p class='error-p'>ERRORS &lt;$origin&gt;:
    ");
    foreach ($errors as $error) {
      echo("
          <br/> - $error
      ");
    }
    echo("
      </p>
    ");
  }
?>