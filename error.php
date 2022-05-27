<!-- 
    Last edited: 5PM 13/05/2022
    By: Orsan Routt
    Details: creation of error feedback
-->

<?php
  function echo_error($errors, $origin, $class = '') {
    echo("
      <p class='error-p $class'>ERRORS &lt;$origin&gt;:
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