<?php
# Some data checking/getting functions.
# Use $error to report errors.
# Example usage:
# GLOBAL $ERROR;
# $username = check_regex("/^\w{1,30}$/", get_post("username"), "Username must be 1-30 alphanumeric/underscore characters.");
# $password = check_regex("/^\w{9,30}$/", get_post("password"), "Password must be 9-30 alphanumeric/underscore characters.");
# if ($error == null) {
#   <code>
# } else {
# echo("<p>$error</p>");
# }
$ERROR = null;

function sanitise_string($str) {
  return htmlspecialchars(stripslashes(trim($str)));
}

function get_action($accepted) {
  GLOBAL $ERROR;
  if ($ERROR == null) {
    if (isset($_GET["action"])) {
      $value = sanitise_string($_GET["action"]);
      if (in_array($value, $accepted)) {
        return $value;
      } else {
        $ERROR = "Invalid GET action.";
        return null;
      }
    }
    return "default";
  }
}

function get_post($key) {
  GLOBAL $ERROR;
  if ($ERROR == null) {
    if (isset($_POST[$key])) {
      return sanitise_string($_POST[$key]);
    }
    $ERROR = "POST key: '$key' not found.";
  }
  return null;
}

function get_session($key) {
  GLOBAL $ERROR;
  if ($ERROR == null) {
    if (isset($_SESSION[$key])) {
      return sanitise_string($_SESSION[$key]);
    }
    $ERROR = "SESSION key: '$key' not found.";
  }
  return null;
}

function check_regex($pattern, $str, $errorMsg) {
  GLOBAL $ERROR;
  if ($ERROR == null and ($str == null or !preg_match($pattern, $str))) {
    $ERROR = $errorMsg;
  }
  return $str;
}
?>