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
        $errors = [];

        if (isset($data_array["fname"])) {
            if (!preg_match("/^[a-zA-Z\s-]+$/", $data_array["fname"])) {
                array_push($errors, "Only alpha letters and hyphen are allowed in your first name.");
            } elseif(strlen($data_array["fname"]) > 30) {
                array_push($errors, "First name is too long, maximum is 30 characters.");
            }
        }

        if (isset($data_array["lname"])) {
            if (!preg_match("/^[a-zA-Z\s-]+$/", $data_array["lname"])) {
                array_push($errors, "Only alpha letters and hyphen are allowed in your last name.");
            } elseif(strlen($data_array["lname"]) > 30) {
                array_push($errors, "Last name is too long, maximum is 30 characters.");
            }
        }

        if (isset($data_array["sid"])) {
            if ($data_array["sid"] == "") {
                array_push($errors, "You must enter your student id.");
            } elseif (!is_numeric($data_array["sid"])) {
                array_push($errors, "Your student id must be a number.");
            } elseif (!preg_match('/^(\d{7}|\d{10})$/', $data_array["sid"])) {
                array_push($errors, "Your student id must be between 7 to 10 digits.");
            }
        }
        
        if (count($errors) == 0) {
            return null;
        }
        return $errors;
    }
?>