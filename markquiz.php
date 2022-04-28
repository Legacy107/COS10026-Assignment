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
    <?php include('header.inc')
    ?>

    <main class="markquiz-main">
        <h1>QUIZ COMPLETED!</h1>

        <section class="markquiz-card">
            <h2 class="markquiz-card-heading">Student Results</h2>

            <p>Student ID is: </p>
            <p>Name: </p>
            <p>Total Score: </p>
            <p>Maximum Score: </p>
            <p>Attempt Number: 1/2</p>
            <p>Date Attempted: </p>

            <form class="markquiz-form">
                <button class="markquiz-button" formaction="./quiz.php#quiz-page">Quiz Page</button>
            </form>
        </section>

        <section class="markquiz-card">
            <h2 class="markquiz-card-heading">Student Results</h2>

            <p>Student ID is: </p>
            <p>Name: </p>
            <p>Total Score: </p>
            <p>Maximum Score: </p>
            <p>Attempt Number: 2/2</p>
            <p>Date Attempted: </p>

            <form class="markquiz-form">
                <button class="markquiz-button" formaction="./topic.php#topic-page">Topic Page</button>
            </form>
        </section>
    </main>

    <?php include('footer.inc')
    ?> 
</body>
</html>