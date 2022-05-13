<?php 
    include_once "data_input.php";
    include_once "database.php";
    include_once "error.php";

    # Redirects to the login page while passing an error message in $_SESSION.
    function login_error($errorMsg) {
        session_unset();
        $_SESSION["errorMsg"] = $errorMsg;
        $_SESSION["errorOri"] = "manage.php";
        header("Location: login.php?action=error");
        exit();
    }
  
    session_start();
    # Try connecting to MySQL database.
    $conn = get_conn();
    if ($conn == null) {
        login_error("Unable to connect to MySQL database.");
    }
    # Try get an ID from the session. Skip if found.
    $adminId = get_session("adminId");
    if ($adminId == null) {
        # If not found try from post.
        $username = get_post("username");
        $password = get_post("password");
        # Detect null username / password.
        if ($username == null) {
            login_error("Username not found in post.");
        }
        if ($password == null) {
            login_error("Password not found in post");
        }
        # Detect incorrect format for username / password.
        if (!preg_match("/^\w{1,30}$/", $username)) {
            login_error("Username must be 1-30 alphanumeric/underscore characters.");
        }
        if (!preg_match("/^\w{9,30}$/", $password)) {
            login_error("Password must be 9-30 alphanumeric/underscore characters.");
        }
        # Try query for username + password.
        try {
            $result = mysqli_query($conn, "SELECT id FROM admins WHERE username = '$username' and password = '$password'");
        } catch (Exception $_ex) {
            login_error("Credential query failed.");
        }
        # Detect incorrect username + password.
        if (mysqli_num_rows($result) <= 0) {
            login_error("Incorrect username or password.");
        }
        $_SESSION["adminId"] = mysqli_fetch_array($result)[0];
    }

    $nameReg = "/^[a-zA-Z\s-]{0,30}$/";
    $sidReg = "/^(\d{7}|\d{10})?$/";

    $action = get_action();

    switch ($action) {
        case 'filter':
            $_SESSION["fname"] = get_post("fname") ?: null;
            $_SESSION["lname"] = get_post("lname") ?: null;
            $_SESSION["sid"] = get_post("sid") ?: null;
            $_SESSION["filter"] = get_post("filter");
            break;
        case 'delete':
            $deleteSid = get_post("user_id");
            if ($deleteSid != null) {
                delete_user($conn, $deleteSid);
            }
            break;
        case 'edit':
            $attemptId = get_post('attempt_id');
            $attempt_value = get_post('attempt_value');
            if ($attemptId != null and $attempt_value != null and preg_match("/^[0-6]$/", $attempt_value)) {
                update_attempt($conn, $attemptId, $attempt_value);
            }
            break;
        default:
            $_SESSION["filter"] = "all";
            break;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Management page for the HTML Boys' MP3 website."/>
    <meta name="keywords" content="HTML, CSS, PHP, Management"/>
    <meta name="author" content="Orson Routt, Kien Quoc Mai, Yong Yuan Chong, Keath Kor"/>
    <title>Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gelasio:ital,wght@0,500;1,500&family=Gravitas+One&family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css"/>
</head>
<body>
    <?php include "header.inc" ?>

    <main id="manage-main">
        <h1 id="manage-mainheading">Manage Attempts</h1>
        <form method="post" action="manage.php?action=filter">
            <fieldset id="manage-filters">
                <div class="manage-filterarea">
                    <h4>
                        <label class="manage-label" for="fname">First Name</label>
                    </h4>
                    <input
                        type="text" id="fname" class="manage-textinput" name="fname" pattern="^[a-zA-Z\s-]{0,30}$" title="Please enter upper or lower case letters only, spaces are allowed. Maximum 30 characters"
                        <?php
                            $fname = get_session("fname");
                            if ($fname != null and preg_match($nameReg, $fname)) {
                                echo("value=\"$fname\"");
                            }
                        ?>
                    />
                </div>
                <div class="manage-filterarea">
                    <h4>
                        <label class="manage-label" for="lname">Last Name</label>
                    </h4>
                    <input
                        type="text" id="lname" class="manage-textinput" name="lname" pattern="^[a-zA-Z\s-]{0,30}$" title="Please enter upper or lower case letters only, spaces are allowed. Maximum 30 characters"
                        <?php
                            $lname = get_session("lname");
                            if ($lname != null and preg_match($nameReg, $lname)) {
                                echo("value=\"$lname\"");
                            }
                        ?>
                    />
                </div>
                <div class="manage-filterarea">
                    <h4>
                        <label class="manage-label" for="sid">Student ID</label>
                    </h4>
                    <input
                        type="text" id="sid" class="manage-textinput" name="sid" pattern="^(\d{7}|\d{10})?$" title="Please enter 7 or 10 digits."
                        <?php
                            $sid = get_session("sid");
                            if ($sid != null and preg_match($sidReg, $sid)) {
                                echo("value=\"$sid\"");
                            }
                        ?>
                    />
                </div>
                <br/>
                <div class="manage-filterarea">
                    <h4>
                        <label class="manage-label" for="filter">Filter Options</label>
                    </h4>
                    <select id="filter" name="filter">
                        <?php
                            $options = array(
                                "all"               => "All",
                                "name"              => "By name",
                                "sid"               => "By student ID",
                                "100_first"         => "100% on first attempt",
                                "less_50_second"    => "&lt;50% on second attempt",
                            );
                            $filter = get_session("filter");

                            foreach ($options as $key => $option) {
                                echo("<option value=\"$key\"");
                                echo($filter == $key ? " selected>\n" : ">\n");
                                echo("$option\n</option>");
                            }
                        ?>
                    </select>
                </div>
            </fieldset>
            <br/>
            <input type="submit" class="manage-submit" value="Filter"/>
        </form>

        <?php
            function echo_attempts_table($data) {
                $length = count($data);
                for ($i = 0; $i < $length; $i++) {
                    echo("
                        <form id=\"attempt$i\" method=\"post\" action=\"manage.php?action=edit\"></form>
                    ");
                }
                echo("
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Date Added</th>
                            <th>Score</th>
                            <th>Action</th>
                        </tr>
                ");
                if ($length == 0) {
                    echo("
                        <tr>
                            <td colspan=\"6\">No attempts found.</td>
                        </tr>"
                    );
                } else {
                    $count = 0;
                    foreach ($data as $row) {
                        echo("
                            <tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["studentid"] . "</td>
                                <td>" . $row["firstname"] . " " . $row["lastname"] . "</td>
                                <td>" . $row["dateCreated"] . "</td>
                                <td>
                                    <input type=\"hidden\" name=\"attempt_id\" value=\"" . $row["id"] . "\" form=\"attempt$count\"/>
                                    <input type=\"number\" class=\"manage-score\" name=\"attempt_value\" min=\"0\" max=\"6\" value=\"" . $row["score"] . "\" form=\"attempt$count\" required/>
                                </td>
                                <td>
                                    <input type=\"submit\" class=\"manage-edit\" value=\"Edit\" form=\"attempt$count\"/>
                                </td>
                            </tr>
                        ");
                        $count += 1;
                    }
                }
                echo("
                    </table>
                ");
            }

            function echo_users_table($data) {
                $length = count($data);
                for ($i = 0; $i < $length; $i++) {
                    echo("
                        <form id=\"user$i\" method=\"post\" action=\"manage.php?action=delete\"></form>
                    ");
                }
                echo("
                    <table>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                ");
                if ($length == 0) {
                    echo("
                        <tr>
                            <td colspan=\"3\">No users found.</td>
                        </tr>"
                    );
                } else {
                    $count = 0;
                    foreach ($data as $key => $row) {
                        echo("
                            <tr>
                                <td>" . $key . "</td>
                                <td>" . $row[0] . " " . $row[1] . "</td>
                                <td>
                                    <input type=\"hidden\" name=\"user_id\" value=\"" . $key . "\" form=\"user$count\"/>
                                    <input type=\"submit\" class=\"manage-edit manage-delete\" value=\"Delete\" form=\"user$count\"/>
                                </td>
                            </tr>
                        ");
                        $count += 1;
                    }
                }
                echo("
                    </table>
                ");
            }

            function echo_manage_error($errors) {
                echo_error($errors, "manage.php");
            }

            function make_tables() {
                GLOBAL $conn, $nameReg, $sidReg;
                $errorMsg = validate_user_data($_SESSION);
                if ($errorMsg != null) {
                    echo_manage_error($errorMsg);
                    return;
                }

                # check filter
                switch ($_SESSION["filter"]) {
                    case 'name':
                        $fname = get_session("fname");
                        $lname = get_session("lname");
                        if ($fname != null and !preg_match($nameReg, $fname)) {
                            $fname = null;
                            $_SESSION["fname"] = null;
                        }
                        if ($lname != null and !preg_match($nameReg, $lname)) {
                            $lname = null;
                            $_SESSION["lname"] = null;
                        }
                        $attempts = get_attempts($conn, null, $fname, $lname);
                        break;
                    case 'sid':
                        $sid = get_session("sid");
                        if ($sid != null and !preg_match($sidReg, $sid)) {
                            $sid = null;
                            $_SESSION["sid"] = null;
                        }
                        $attempts = get_attempts($conn, $sid);
                        break;
                    case '100_first':
                        $attempts =  get_first_attempts_100($conn);
                        break;
                    case 'less_50_second':
                        $attempts =  get_second_attempts_lt_50($conn);
                        break;
                    default:
                        $attempts = get_attempts($conn);
                        break;
                }

                if (gettype($attempts) == "NULL") {
                    echo_manage_error(["Failed fetching attempts from SQL database."]);
                    return;
                }

                $users = [];
                foreach ($attempts as $attempt) {
                    $users[$attempt["studentid"]] = [$attempt["firstname"], $attempt["lastname"]];
                }
                
                echo("<h2 class=\"manage-listheading\">List of Attempts</h2>");
                echo_attempts_table($attempts);

                echo("<h2 class=\"manage-listheading\">List of Users</h2>");
                echo_users_table($users);
            }
            make_tables();
        ?>
    </main>
    
    <form method="post" action="logout.php">
        <input type="submit" id="manage-logout" class="manage-submit" value="Logout"/>
    </form>
    
    <?php
        mysqli_close($conn);
    ?>
    <?php include "footer.inc" ?>
</body>
</html>