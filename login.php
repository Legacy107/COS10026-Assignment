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
    <?php include('header.inc')
    ?>

    <h1 class="login-h1">Admin Panel</h1>

    <form method="POST" action="">
        <div class="login-form__wrapper">
            <div class="login-form">
                <label for="admin_name" class="login-label__name">Username</label>
                <br />
                <input type="text" name="admin_name" id="admin_name" />
                <br />
                <label for="admin_password">Password</label>
                <br />
                <input type="text" name="admin_password" id="admin_password" />
            </div>
        </div>
        <input type="submit" value="LOGIN" class="login-submit" />
    </form>

    <?php include('footer.inc')
    ?>
</body>

</html>