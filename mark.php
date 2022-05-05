<?php
    // Sanitise
    function sanitise_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function GetData() {
        $dataArray = array();
        if (isset($_POST["fname"])) { //text alpha
            array_push($dataArray, $_POST["fname"]);
        }

        if (isset($_POST["lname"])) { //text alpha
            array_push($dataArray, $_POST["lname"]);
        }

        if (isset($_POST["sid"])) { //text numeric
            array_push($dataArray, $_POST["sid"]);
        }

        if (isset($_POST["MPEG"])) { //text alpha
            array_push($dataArray, $_POST["MPEG"]);
        }

        if (isset($_POST["years"])) { //radio
            array_push($dataArray, $_POST["years"]);
        }

        if (isset($_POST["standards"])) { //checkbox
            array_push($dataArray, $_POST["standards"]);
        }

        if (isset($_POST["decline"])) { //checkbox
            array_push($dataArray, $_POST["decline"]);
        }

        if (isset($_POST["creator"])) { //select
            array_push($dataArray, $_POST["creator"]);
        }

        if (isset($_POST["compression"])) { //radio
            array_push($dataArray, $_POST["compression"]);
        }

        return $dataArray;
    }

    // Mark data to points
    function MarkQuestion($dataArray) {
        $totalPoints = 0;

        if ($dataArray[3] == "Moving Picture Experts Group") {
            $totalPoints += 1;
        }
        
        if ($dataArray[4] == "1995 / 1998") {
            $totalPoints += 1;
        }

        $pointStandards = 0;
        for ($i=0; $i<count($dataArray[5]); $i++) {
            if (($dataArray[5])[$i] == "MPEG 1 Audio layer III") {
                $pointStandards += 0.5;
            }

            if (($dataArray[5])[$i] == "MPEG 2 Audio Layer III") {
                $pointStandards += 0.5;
            }

            if (($dataArray[5])[$i] == "MPEG 2.5 Audio Layer III") {
                $pointStandards -= 0.5;
            }

            if (($dataArray[5])[$i] == "MPEG 3 Audio Layer III") {
                $pointStandards -= 0.5;
            }
        }
        if ($pointStandards > 0) { //If have points, add to total points
            $totalPoints += $pointStandards;
        }

        $pointDecline = 0;
        for ($j=0; $j<count($dataArray[6]); $j++) {
            if (($dataArray[6])[$j] == "variety of devices") {
                $pointDecline += 0.5;
            }

            if (($dataArray[6])[$j] == "legal issues") {
                $pointDecline -= 0.5;
            }

            if (($dataArray[6])[$j] == "alternative audio formats") {
                $pointDecline += 0.5;
            }

            if (($dataArray[6])[$j] == "MPEG changes") {
                $pointDecline -= 0.5;
            }
        }
        if ($pointDecline > 0) { //If have points, add to total points
            $totalPoints += $pointDecline;
        }

        if ($dataArray[7] == "Fraunhofer Society") {
            $totalPoints += 1;
        }

        if ($dataArray[8] == "False") {
            $totalPoints += 1;
        }

        return $totalPoints;
    }
    
    $data = GetData();

    // Sanitize data
    foreach ($data as &$input) {
        if (gettype($input) == "array") {
            foreach ($input as &$field) {
                $filed = sanitise_input($field);
            }
        } else {
            $input = sanitise_input($input);
        }
    }

    // Validate Stuff
    $errMsg = "";
    if (!preg_match("/^[a-zA-Z\s-]{1,30}$/", $data[0])) {
        $errMsg .= "<p>Only alpha letters allowed in your first name.</p>" ;
    }
    else if(strlen($data[0]) > 30)
    {
       echo "first name is too long, maximum is 30 characters.";
    }

    if (!preg_match("/^[a-zA-Z\s-]{1,30}$/", $data[1])) {
        $errMsg .= "<P>Only alpha letters allowed in your last name.</p>" ;
    }
    else if(strlen($data[1]) > 30)
    {
        echo "last name is too long, maximum is 30 characters.";
    }

    if ($data[2] == "") {
        $errMsg .= "<p>You must enter your student id.</p>" ;
    } else if (!is_numeric($data[2])) {
        $errMsg .= "<p>Your student id must be a number.</p>" ;
    } else if (!preg_match('/^(\d{7}|\d{10})$/', $data[2])) {
        $errMsg .= "<p>Your student id must be between 7 to 10 digits.</p>" ;
    }

    if ($errMsg) {
        echo($errMsg);
        exit();
    }

    $points = MarkQuestion($data);

    echo "$points<br>"; //delete later
?>
