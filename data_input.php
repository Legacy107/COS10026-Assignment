<?php
    # Sanitises a string.
    function sanitise_string($str) {
        return htmlspecialchars(stripslashes(trim($str)));
    }

    function sanitise_data($data) {
        if (gettype($data) == "array") {
            foreach ($data as &$field) {
                $field = sanitise_string($field);
            }
        }
        else {
            $data = sanitise_string($data);
        }
        return $data;
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
        return sanitise_data($_POST[$key]);
        }
        return null;
    }

    # Gets a session variable, returns null if it doesn't exist.
    function get_session($key) {
        if (isset($_SESSION[$key])) {
        return sanitise_data($_SESSION[$key]);
        }
        return null;
    }

    # Validate fname, lname and sid
    function validate_user_data($data_array) {
        $err_msg = "";

        if (isset($data_array["fname"])) {
        if (!preg_match("/^[a-zA-Z\s-]+$/", $data_array["fname"])) {
            $err_msg .= "<p>Only alpha letters and hyphen are allowed in your first name.</p>" ;
        }
        else if(strlen($data_array["fname"]) > 30)
        {
            $err_msg .= "<p>First name is too long, maximum is 30 characters.</p>";
        }
        }

        if (isset($data_array["lname"])) {
        if (!preg_match("/^[a-zA-Z\s-]+$/", $data_array["lname"])) {
            $err_msg .= "<P>Only alpha letters and hyphen are allowed in your last name.</p>";
        }
        else if(strlen($data_array["lname"]) > 30)
        {
            $err_msg .= "<p>Last name is too long, maximum is 30 characters.</p>";
        }
        }

        if (isset($data_array["sid"])) {
        if ($data_array["sid"] == "") {
            $err_msg .= "<p>You must enter your student id.</p>";
        } else if (!is_numeric($data_array["sid"])) {
            $err_msg .= "<p>Your student id must be a number.</p>";
        } else if (!preg_match('/^(\d{7}|\d{10})$/', $data_array["sid"])) {
            $err_msg .= "<p>Your student id must be between 7 to 10 digits.</p>";
        }
        }

        return $err_msg;
    }
?>