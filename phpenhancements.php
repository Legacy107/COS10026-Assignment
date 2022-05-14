<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Enhancements page for the HTML Boys' MP3 website."/>
    <meta name="keywords" content="HTML, CSS, Enhancements"/>
    <meta name="author" content="Orson Routt, Peter Farmer, Kien Quoc Mai, Yong Yuan Chong, Keath Kor"/>
    <title>PHP &amp SQL Enhancements</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gelasio:ital,wght@0,500;1,500&family=Gravitas+One&family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css"/>
</head>
<body>
    <?php include('header.inc') ?>

    <main class="enhancements-main">
        <h1 class="enhancements-main__title">PHP &amp SQL Enhancements</h1>

        <section>
            <div class="enhancements-article__demo">
                <img class="enhancements-article__demoImg" id="enhancements-dbnormalize" src="images/db-normalize.png" alt="database normalization">
            </div>

            <div class="enhancements-article__description">
                <h2>Database normalization</h2>
                <p>User's table and attempt's table are linked together using a one-to-many relationship between them. As a result, data duplication is minimized. In order to retrieve the data, "INNER JOIN" is used to merge information between the tables.</p>
            </div>
        </section>

        <section>
            <div class="enhancements-article__demo">
                <a href="./logout.php#login-form">
                    <img class="enhancements-article__demoImg" id="enhancements-loginDemo" src="images/login.png" alt="login page demo">
                </a>
                <img class="enhancements-article__demoImg" id="enhancements-adminTableDemo" src="images/admin-table.png" alt="admin table's schema">
            </div>

            <div class="enhancements-article__description">
                <h2>Admin login</h2>
                <p>To get access to the manage page, admins must login with their credentials. Then, they will be checked against the database. If the provided credentials are correct, session data will be set and the admin will be able to access the manage page.</p>
            </div>
        </section>
    </main>

 
    <?php include('footer.inc') ?>
</body>
</html>
