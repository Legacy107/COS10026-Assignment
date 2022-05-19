<!-- 
    Last edited: 5PM 13/05/2022
    By: Orsan Routt
    Details: creation of error feedback
-->

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