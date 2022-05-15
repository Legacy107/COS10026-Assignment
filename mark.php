
<?php
    include_once "data_input.php";
    include "db_settings.php";
    include "database.php";

    function quiz_error($errors)
    {
        session_start();
        session_unset();
        $_SESSION["errorMsg"] = $errors;
        $_SESSION["errorOri"] = "mark.php";
        header("Location: quiz.php?action=error");
        exit();
    }

    function sanitise_data_array($data_array)
    {
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

    function get_data()
    {
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
    function mark_question($data_array)
    {
        $total_points = 0;

        if ($data_array["MPEG"] == "Moving Picture Experts Group") {
            $total_points += 2;
        }

        if ($data_array["years"] == "1995 / 1998") {
            $total_points += 2;
        }

        $point_standards = 0;
        for ($i = 0; $i < count($data_array["standards"]); $i++) {
            if ($data_array["standards"][$i] == "MPEG 1 Audio layer III") {
                $point_standards += 1;
            }

            if ($data_array["standards"][$i] == "MPEG 2 Audio Layer III") {
                $point_standards += 1;
            }

            if ($data_array["standards"][$i] == "MPEG 2.5 Audio Layer III") {
                $point_standards -= 1;
            }

            if ($data_array["standards"][$i] == "MPEG 3 Audio Layer III") {
                $point_standards -= 1;
            }
        }
        if ($point_standards > 0) { //If have points, add to total points
           $total_points += $point_standards;
        }

        $point_decline = 0;
        for ($i = 0; $i < count($data_array["decline"]); $i++) {
            if ($data_array["decline"][$i] == "variety of devices") {
                $point_decline += 1;
            }

            if ($data_array["decline"][$i] == "legal issues") {
                $point_decline -= 1;
            }

            if ($data_array["decline"][$i] == "alternative audio formats") {
                $point_decline += 1;
            }

            if ($data_array["decline"][$i] == "MPEG changes") {
                $point_decline -= 1;
            }
        }
        if ($point_decline > 0) { //If have points, add to total points
            $total_points += $point_decline;
        }

        if ($data_array["creator"] == "Fraunhofer Society") {
            $total_points += 2;
        }

        if ($data_array["compression"] == "False") {
            $total_points += 2;
        }

        return $total_points;
    }

    //Checks submission count, and uploads to submission server if user has performed less than 2 attempts
    function submit_results($conn, $data, $score)
    {
        $query = "SELECT * FROM attempts WHERE userid = " .  $data["sid"];
        $result = mysqli_query($conn, $query);
        $rows = mysqli_num_rows($result);
        if ($rows >= 2) {
            $errors = [];
            array_push($errors, "Two attempts already completed.");
            quiz_error($errors);
        }
        if ($rows == 0) {
            save_user($conn, $data["sid"], $data["fname"], $data["lname"]);
        }
        save_attempt($conn, $data["sid"], $score);
    }

    $data = get_data();

    $data = sanitise_data_array($data);

    $errors = validate_user_data($data);

    #displays any errors that have occurred server side to the user
    if ($errors != null) {
        quiz_error($errors);
    }

    $points = mark_question($data);

    if ($points == 0) {
        $errors = [];
        array_push($errors, "Score achieved is zero. Attempt has not counted, please attempt again.");
        quiz_error($errors);
    }

    $conn = get_conn();

    if ($conn) {
        submit_results($conn, $data, $points);
    } else {
        $errors = [];
        array_push($errors, "Connection with server was not established, please contact the team to resolve issues. Please try again later");
    }

    mysqli_close($conn);

    header("Location: markquiz.php");
    exit();
?>