<?php
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

    //Sanitise
    //Validate Stuff


    //Mark data to points
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
    $points = MarkQuestion($data);

    echo "$points<br>"; //delete later

    if (false) { //validate fail, 0 score, already 2 attempts
        echo "<p>
            reasons why.
        </p>";

    } else {
        echo "Placeholder: To markquiz page."; //delete later
        //Send data to SQL
        //header ("location: markquiz.php");
    }
?>