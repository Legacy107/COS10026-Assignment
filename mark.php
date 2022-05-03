<?php
    if (isset($_POST["fname"])) { //text alpha
        $fname = $_POST["fname"];
    }

    if (isset($_POST["lname"])) { //text alpha
        $lname = $_POST["lname"];
    }

    if (isset($_POST["sid"])) { //text numeric
        $sid = $_POST["sid"];
    }

    if (isset($_POST["MPEG"])) { //text alpha
        $mpeg = $_POST["MPEG"];
    }

    if (isset($_POST["years"])) { //radio
        $years = $_POST["years"];
    }

    if (isset($_POST["standards"])) { //checkbox
        $standards = $_POST["standards"];
    }

    if (isset($_POST["decline"])) { //checkbox
        $decline = $_POST["decline"];
    }

    if (isset($_POST["creator"])) { //select
        $creator = $_POST["creator"];
    }

    if (isset($_POST["compression"])) { //radio
        $compression = $_POST["compression"];
    }

    //Sanitise
    //Validate Stuff


    //Mark data to points
    echo "<p>Name: $fname $lname</p>"; //delete later
    echo "<p>ID: $sid</p>"; //delete later

    $totalPoints = 0;

    if ($mpeg == "Moving Picture Experts Group") {
        $totalPoints += 1;
        echo "<p>MPEG YES</p>"; //delete later
    }
    echo "$mpeg<br>"; //delete later
    
    if ($years == "1995 / 1998") {
        $totalPoints += 1;
        echo "<p>Years YES</p>"; //delete later
    }
    echo "$years<br>"; //delete later

    $pointStandards = 0;
    for ($i=0; $i<count($standards); $i++) {
        if ($standards[$i] == "MPEG 1 Audio layer III") {
            $pointStandards += 0.5;
            echo "<p>Standards1 YES</p>"; //delete later
        }

        if ($standards[$i] == "MPEG 2 Audio Layer III") {
            $pointStandards += 0.5;
            echo "<p>Standards2 YES</p>"; //delete later
        }

        if ($standards[$i] == "MPEG 2.5 Audio Layer III") {
            $pointStandards -= 0.5;
        }

        if ($standards[$i] == "MPEG 3 Audio Layer III") {
            $pointStandards -= 0.5;
        }
        
        echo $standards[$i]; //delete later
    }
    if ($pointStandards > 0) { //If have points, add to total points
        $totalPoints += $pointStandards;
    }
    echo "<br>"; //delete later

    $pointDecline = 0;
    for ($j=0; $j<count($decline); $j++) {
        if ($decline[$j] == "variety of devices") {
            $pointDecline += 0.5;
            echo "<p>Decline1 YES</p>"; //delete later
        }

        if ($decline[$j] == "legal issues") {
            $pointDecline -= 0.5;
        }

        if ($decline[$j] == "alternative audio formats") {
            $pointDecline += 0.5;
            echo "<p>Decline2 YES</p>"; //delete later
        }

        if ($decline[$j] == "MPEG changes") {
            $pointDecline -= 0.5;
        }

        echo $decline[$j]; //delete later
    }
    if ($pointDecline > 0) { //If have points, add to total points
        $totalPoints += $pointDecline;
    }
    echo "<br>"; //delete later

    if ($creator == "Fraunhofer Society") {
        $totalPoints += 1;
        echo "<p>Creator YES</p>"; //delete later
    }
    echo "$creator<br>"; //delete later

    if ($compression == "False") {
        $totalPoints += 1;
        echo "<p>Compression YES</p>"; //delete later
    }
    echo "$compression<br>"; //delete later

    echo "$totalPoints<br>"; //delete later


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