<?php
  # Sanitises a string.
  function sanitise_string($str) {
    return htmlspecialchars(stripslashes(trim($str)));
  }

  # Gets $_GET["action"], returns null if it doesn't exist.
  function get_action() {
    if (isset($_GET["action"])) {
      return sanitise_string($_GET["action"]);
    }
    return null;
  }

  # Gets a post variable, returns null if it doesn't exist.
  function get_post($key) {
    if (isset($_POST[$key])) {
      return sanitise_string($_POST[$key]);
    }
    return null;
  }

  # Gets a session variable, returns null if it doesn't exist.
  function get_session($key) {
    if (isset($_SESSION[$key])) {
      return sanitise_string($_SESSION[$key]);
    }
    return null;
  }
?>