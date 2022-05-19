<!-- 
    Last edited: 11AM 12/05/2022
    By: Orsan Routt
    Details: Created
-->
<?php
  session_start();
  session_unset();
  session_destroy();
  header("Location: login.php");
?>