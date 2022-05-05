<?php
    // Sanitise
    function sanitise_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function sanitise_data($data_array) {
        foreach ($data_array as &$input) {
            if (gettype($input) == "array") {
                foreach ($input as &$field) {
                    $filed = sanitise_input($field);
                }
            } else {
                $input = sanitise_input($input);
            }
        }
        return $data_array;
    }

    // Validate
    function validate_data($data_array) {
        $err_msg = "";

        if (!preg_match("/^[a-zA-Z\s-]+$/", $data_array["fname"])) {
            $err_msg .= "<p>Only alpha letters and hyphen are allowed in your first name.</p>" ;
        }
        else if(strlen($data_array["fname"]) > 30)
        {
            $err_msg .= "<p>First name is too long, maximum is 30 characters.</p>";
        }

        if (!preg_match("/^[a-zA-Z\s-]+$/", $data_array["lname"])) {
            $err_msg .= "<P>Only alpha letters and hyphen are allowed in your last name.</p>";
        }
        else if(strlen($data_array["lname"]) > 30)
        {
            $err_msg .= "<p>Last name is too long, maximum is 30 characters.</p>";
        }

        if ($data_array["sid"] == "") {
            $err_msg .= "<p>You must enter your student id.</p>";
        } else if (!is_numeric($data_array["sid"])) {
            $err_msg .= "<p>Your student id must be a number.</p>";
        } else if (!preg_match('/^(\d{7}|\d{10})$/', $data_array["sid"])) {
            $err_msg .= "<p>Your student id must be between 7 to 10 digits.</p>";
        }

        return $err_msg;
    }

    function get_data() {
        $data_array = array();
        if (isset($_POST["fname"])) { //text alpha
            $data_array["fname"] = $_POST["fname"];
        }

        if (isset($_POST["lname"])) { //text alpha
            $data_array["lname"] = $_POST["lname"];
        }

        if (isset($_POST["sid"])) { //text numeric
            $data_array["sid"] = $_POST["sid"];
        }

        if (isset($_POST["MPEG"])) { //text alpha
            $data_array["MPEG"] = $_POST["MPEG"];
        }

        if (isset($_POST["years"])) { //radio
            $data_array["years"] = $_POST["years"];
        }

        if (isset($_POST["standards"])) { //checkbox
            $data_array["standards"] = $_POST["standards"];
        }

        if (isset($_POST["decline"])) { //checkbox
            $data_array["decline"] = $_POST["decline"];
        }

        if (isset($_POST["creator"])) { //select
            $data_array["creator"] = $_POST["creator"];
        }

        if (isset($_POST["compression"])) { //radio
            $data_array["compression"] = $_POST["compression"];
        }

        return $data_array;
    }

    // Mark data to points
    function mark_question($data_array) {
        $total_points = 0;

        if ($data_array["MPEG"] == "Moving Picture Experts Group") {
            $total_points += 1;
        }
        
        if ($data_array["years"] == "1995 / 1998") {
            $total_points += 1;
        }

        $point_standards = 0;
        for ($i = 0; $i < count($data_array["standards"]); $i++) {
            if ($data_array["standards"][$i] == "MPEG 1 Audio layer III") {
                $point_standards += 0.5;
            }

            if ($data_array["standards"][$i] == "MPEG 2 Audio Layer III") {
                $point_standards += 0.5;
            }

            if ($data_array["standards"][$i] == "MPEG 2.5 Audio Layer III") {
                $point_standards -= 0.5;
            }

            if ($data_array["standards"][$i] == "MPEG 3 Audio Layer III") {
                $point_standards -= 0.5;
            }
        }
        if ($point_standards > 0) { //If have points, add to total points
            $total_points += $point_standards;
        }

        $point_decline = 0;
        for ($i = 0; $i < count($data_array["decline"]); $i++) {
            if ($data_array["decline"][$i] == "variety of devices") {
                $point_decline += 0.5;
            }

            if ($data_array["decline"][$i] == "legal issues") {
                $point_decline -= 0.5;
            }

            if ($data_array["decline"][$i] == "alternative audio formats") {
                $point_decline += 0.5;
            }

            if ($data_array["decline"][$i] == "MPEG changes") {
                $point_decline -= 0.5;
            }
        }
        if ($point_decline > 0) { //If have points, add to total points
            $total_points += $point_decline;
        }

        if ($data_array["creator"] == "Fraunhofer Society") {
            $total_points += 1;
        }

        if ($data_array["compression"] == "False") {
            $total_points += 1;
        }

        return $total_points;
    }


    $data = get_data();

    $data = sanitise_data($data);

    $err_msg = validate_data($data);

    if ($err_msg) {
        echo($err_msg);
        exit();
    }

    $points = mark_question($data);

    echo "$points<br>"; //delete later
?>
