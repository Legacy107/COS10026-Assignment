<?php
    include_once "data_input.php";

    function sanitise_data_array($data_array) {
        foreach ($data_array as &$input) {
            if (gettype($input) == "array") {
                foreach ($input as &$field) {
                    $field = sanitise_string($field);
                }
            } else {
                $input = sanitise_string($input);
            }
        }
        return $data_array;
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

    $data = sanitise_data_array($data);

    $err_msg = validate_user_data($data);

    if ($err_msg) {
        echo($err_msg);
        exit();
    }

    $points = mark_question($data);

    echo "$points<br>"; //delete later
?>
