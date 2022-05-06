<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin login page for results access." />
    <meta name="keywords" content="MP3, Login, Admin" />
    <meta name="author" content="Peter Farmer" />
    <title>Admin Login Page</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gelasio:ital,wght@0,500;1,500&family=Gravitas+One&family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css" />
</head>

<body>
    <?php include('header.inc')?>
    <main class="login-main">
        <h1 class="login-h1">Admin Panel</h1>

        <?php
            include "data_checking.php";

            GLOBAL $ERROR;
            session_start();
            $action = get_action(["error"]);
            if ($ERROR == null) {
                if ($action == "error") {
                    $errorMsg = get_session("errorMsg");
                    if ($ERROR == null) {
                        $ERROR = $errorMsg;
                    }
                }
            }
            session_unset();
            session_destroy();
            if ($ERROR != null) {
                echo("<p id='login-error'>ERROR: $ERROR</p>");
            }
        ?>

        <form method="POST" action="manage.php" novalidate>
            <div class="login-form__wrapper">
                <div class="login-form">
                    <label for="admin_name" class="login-label__name">Username</label>
                    <br />
                    <input type="text" name="username" id="admin_name" pattern="^\w{1,30}$" title="Username must be 1-30 alphanumeric/underscore characters." required/>
                    <br />
                    <label for="admin_password">Password</label>
                    <br />
                    <input type="password" name="password" id="admin_password" pattern="^\w{9,30}$" title="Password must be 9-30 alphanumeric/underscore characters." required/>
                </div>
            </div>
            <input type="submit" value="LOGIN" class="login-submit" />
        </form>
    </main>
    <?php include('footer.inc')?>
</body>

</html>