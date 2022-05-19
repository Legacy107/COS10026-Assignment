<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="author" content=""/>
    <title>Mark Quiz</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gelasio:ital,wght@0,500;1,500&family=Gravitas+One&family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css"/>
</head>
<body>
    <?php include('header.inc');
        require_once "data_input.php";
        require_once "database.php";

        session_start();

        $conn = get_conn();
        if ($conn == null) {
            echo "Unable to connect database.";
        }

        $current_sid = get_session("current_sid");

        $queryAttempts = "SELECT * FROM attempts WHERE userid = $current_sid"; //userId, score, dateCreated, dateUpdated
        $queryUsers = "SELECT * FROM users WHERE id = $current_sid"; //id, firstName, lastName

        $resultAttempts = mysqli_query($conn, $queryAttempts);
        $resultUsers = mysqli_query($conn, $queryUsers);

        $rowsAttempts = mysqli_num_rows($resultAttempts); //check for if there is attempt 2

        $data_array = array();

        if (!$resultAttempts) {
            echo "<p>Something is wrong with ", $queryAttempts, "</p>";
        }
        if (!$resultUsers) {
            echo "<p>Something is wrong with ", $queryUsers, "</p>";
        }

        $i = 0;
        while ($row = mysqli_fetch_assoc($resultAttempts)) {
            if ($i == 0) { //attempt 1
                $data_array["score1"] = $row["score"];
                $data_array["dateCreate1"] = $row["dateCreated"];
            } else { //attempt 2
                $data_array["score2"] = $row["score"];
                $data_array["dateCreate2"] = $row["dateCreated"];
            }
            $i++;
        }

        while ($row = mysqli_fetch_assoc($resultUsers)) {
            $data_array["sid1"] = $row["id"];
            $data_array["firstname1"] = $row["firstName"];
            $data_array["lastname1"] = $row["lastName"];
        }
    ?>

    <main class="markquiz-main">
        <h1>QUIZ COMPLETED!</h1>

        <section class="markquiz-card">
            <h2 class="markquiz-card-heading">Student Results</h2>

            <p>Student ID is: <?php echo $data_array["sid1"]; ?></p>
            <p>Name: <?php echo $data_array["firstname1"] . " " . $data_array["lastname1"]; ?></p>
            <p>Total Score: <?php echo $data_array["score1"]; ?></p>
            <p>Maximum Score: 12</p>
            <p>Attempt Number: 1/2</p>
            <p>Date Attempted: <?php echo $data_array["dateCreate1"]; ?></p>

            <?php
                if ($rowsAttempts != 2) { //if attempt 2 is not done, make button link to quiz
                    echo "<form class=\"markquiz-form\">";
                        echo "<button class=\"markquiz-button\" formaction=\"./quiz.php#quiz-page\">Quiz Page</button>";
                    echo "</form>";
                }
            ?>
        </section>

        <?php
            if ($rowsAttempts >= 2) {
                echo "<section class=\"markquiz-card\">";
                    echo "<h2 class=\"markquiz-card-heading\">Student Results</h2>";

                    echo "<p>Student ID is: " . $data_array["sid1"] . "</p>";

                    echo "<p>Name: " . $data_array["firstname1"] . " " . $data_array["lastname1"] . "</p>";

                    echo "<p>Total Score: " . $data_array["score2"] . "</p>";

                    echo "<p>Maximum Score: 12</p>";

                    echo "<p>Attempt Number: 2/2</p>";

                    echo "<p>Date Attempted: " . $data_array["dateCreate2"] . "</p>";

                    echo "<form class=\"markquiz-form\">";
                        echo "<button class=\"markquiz-button\" formaction=\"./topic.php#topic-page\">Topic Page</button>";
                    echo "</form>";
                echo "</section>";
            }
        ?>
    </main>

    <?php include('footer.inc');
        mysqli_close($conn);
    ?> 
</body>
</html>