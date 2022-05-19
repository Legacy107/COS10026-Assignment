<!-- 
    Last edited: 1PM 19/5/2022
    By: Quoc Mai
    Details: Hash of passwords for server access
-->

<?php
    require_once "db_settings.php";

    # Gets a connection to the MySQL database using the config variables. Returns null if it can't connect.
    function get_conn() {
        global $host, $user, $pwd, $sql_db;
        try {
            $conn = mysqli_connect($host, $user, $pwd, $sql_db);
        } catch (Exception $_ex) {
            return null;
        }
        return $conn;
    }

    # Creates the 'admins' table if it doesn't exist.
    function create_admin_table($conn) {
        $query = "CREATE TABLE IF NOT EXISTS admins (
            id INT NOT NULL AUTO_INCREMENT,
            username VARCHAR(30) NOT NULL UNIQUE,
            password VARCHAR(90) NOT NULL,
            failedAttempt TINYINT DEFAULT 0,
            blockUntil TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        )";
        try {
            mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return false;
        }
        return true;
    }

    # Creates the 'users' table if it doesn't exist.
    function create_user_table($conn) {
        $query = "CREATE TABLE IF NOT EXISTS users (
            id VARCHAR(10) NOT NULL,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            PRIMARY KEY (id)
        )";
        try {
            mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return false;
        }
        return true;
    }

    # Creates the 'attempts' table if it doesn't exist.
    function create_attempt_table($conn) {
        $query = "CREATE TABLE IF NOT EXISTS attempts (
            id INT NOT NULL AUTO_INCREMENT,
            userId VARCHAR(10) NOT NULL,
            score TINYINT NOT NULL,
            dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            dateUpdated TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (userId) REFERENCES users(id)
        )";
        try {
            mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return false;
        }
        return true;
    }

    # Create a user.
    function save_user($conn, $sid, $fname, $lname) {
        $query = "INSERT INTO users (id, firstname, lastname)
            VALUES ('$sid', '$fname', '$lname');
        ";
        try {
            mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return false;
        }
        return true;
    }

    # Create an attempt.
    function save_attempt($conn, $user_id, $score) {
        $query = "INSERT INTO attempts (userId, score, dateUpdated)
            VALUES ('$user_id', $score, CURRENT_TIMESTAMP);
        ";
        try {
            mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return false;
        }
        return true;
    }

    function get_sql_array($result) {
        $array = [];
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        while ($row != null) {
            array_push($array, $row);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        return $array;
    }

    # Read attempts.
    function get_attempts($conn, $user_id = null, $fname = null, $lname = null) {
        $hasConst = false;
        $query = "SELECT attempts.*, users.firstname, users.lastname, users.id AS studentid FROM attempts INNER JOIN users ON attempts.userId = users.id";

        $const = " WHERE";

        if ($user_id) {
            if ($hasConst) {
                $const .= " and";
            }
            $hasConst = true;
            $const .= " users.id = '$user_id'";
        }
        if ($fname) {
            if ($hasConst) {
                $const .= " and";
            }
            $hasConst = true;
            
            $const .= " users.firstname LIKE '%$fname%'";
        }
        if ($lname) {
            if ($hasConst) {
                $const .= " and";
            }
            $hasConst = true;
            
            $const .= " users.lastname LIKE '%$lname%'";
        }

        if ($hasConst) {
            $query .= $const;
        }

        $query .= " ORDER BY attempts.dateCreated, attempts.id";

        try {
            $result = mysqli_query($conn, $query);

            $attempts = get_sql_array($result);

            mysqli_free_result($result);

            return $attempts;
        } catch (Exception $_ex) {
            return null;
        }
    }

    # Read second attempts with score < 50%.
    function get_second_attempts_lt_50($conn) {
        $query = "SELECT attempts.*, users.firstname, users.lastname, users.id AS studentid FROM attempts
            INNER JOIN users ON attempts.userId = users.id
            INNER JOIN
            (
                SELECT MAX(dateCreated) maxDateCreated, userId, COUNT(id) AS numberOfAttempts
                FROM attempts
                GROUP BY userId
                HAVING numberOfAttempts = 2
            ) temp_attempts
            ON attempts.userId = temp_attempts.userId
            AND attempts.dateCreated = temp_attempts.maxDateCreated
            WHERE attempts.score < 6
            ORDER BY attempts.dateCreated, attempts.id
        ";

        try {
            $result = mysqli_query($conn, $query);

            $attempts = get_sql_array($result);

            mysqli_free_result($result);

            return $attempts;
        } catch (Exception $_ex) {
            return null;
        }
    }

    # Read first attempts with scores of 100%.
    function get_first_attempts_100($conn) {
        $query = "SELECT attempts.*, users.firstname, users.lastname, users.id AS studentid FROM attempts
            INNER JOIN users ON attempts.userId = users.id
            INNER JOIN
            (
                SELECT min(dateCreated) minDateCreated, userId
                FROM attempts
                GROUP BY userId
            ) temp_attempts
            ON attempts.userId = temp_attempts.userId
            AND attempts.dateCreated = temp_attempts.minDateCreated
            WHERE attempts.score = 12
            ORDER BY attempts.dateCreated, attempts.id
        ";

        try {
            $result = mysqli_query($conn, $query);

            $attempts = get_sql_array($result);

            mysqli_free_result($result);

            return $attempts;
        } catch (Exception $_ex) {
            return null;
        }
    }

    # Update an attempt.
    function update_attempt($conn, $id, $score) {
        $query = "UPDATE attempts
            SET score = $score, dateUpdated = CURRENT_TIMESTAMP
            WHERE id = '$id'
        ";
        try {
            mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return false;
        }
        return true;
    }

    # Delete user.
    function delete_user($conn, $sid) {
        $query = "DELETE FROM attempts WHERE userId = $sid";
        try {
            mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return false;
        }

        $query = "DELETE FROM users WHERE id = $sid";
        try {
            mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return false;
        }
        return true;
    }

    function populate_admin_table($conn) {
        $query = "INSERT INTO admins (id, username, password)
            VALUES
            (NULL, 'orson_routt', '" . hash('md5', 'password1') . "'),
            (NULL, 'quoc_mai', '" . hash('md5', 'password2') . "'),
            (NULL, 'peter_farmer', '" . hash('md5', 'password3') . "'),
            (NULL, 'keath_kor', '" . hash('md5', 'password4') . "'),
            (NULL, 'yong_yuan', '" . hash('md5', 'password5') . "')";
        try {
            mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return false;
        }
        return true;
    }

    function update_admin_attempt($conn, $id, $value) {
        $query = "UPDATE admins
            SET failedAttempt = $value
            WHERE id = '$id'
        ";
        try {
            mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return false;
        }
        return true;
    }

    // block an admin account for 15 minutes
    function block_admin($conn, $id) {
        $query = "UPDATE admins
            SET blockUntil = addtime(CURRENT_TIMESTAMP(), 1500)
            WHERE id = '$id'
        ";
        try {
            mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return false;
        }
        return true;
    }

    function authenticate_admin_user($conn, $username, $password) {
        # Explicitly set timezone for consistency
        try {
            $query = "SET time_zone = 'Australia/Melbourne'";
            $result = mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return [
                "errorMsg"  => "Credential query failed.",
                "adminId"   => null,
            ];
        }

        # Try query for username + password.
        try {
            $query = "SELECT id, password, failedAttempt, blockUntil FROM admins 
                WHERE username = '$username';
            ";
            $result = mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return [
                "errorMsg"  => "Credential query failed.",
                "adminId"   => null,
            ];
        }
        # Detect incorrect username
        if (mysqli_num_rows($result) <= 0) {
            return [
                "errorMsg"  => "Incorrect username or password.",
                "adminId"   => null,
            ];
        }

        $admin = get_sql_array($result)[0];

        # Detect blocked account
        $now = new DateTime("now", new DateTimeZone('Australia/Melbourne'));
        $block_until = DateTime::createFromFormat("Y-m-d H:i:s", $admin["blockUntil"]);
        if ($block_until->getTimestamp() > $now->getTimestamp()) {
            $remaining_time = round(($block_until->getTimestamp() - $now->getTimestamp()) / 60.0);
            return [
                "errorMsg"  => "The account has been temporarily blocked. Try again in " . $remaining_time . " minutes.",
                "adminId"   => null,
            ];
        }

        # Detect incorrect password
        if (hash('md5', $password) != $admin["password"]) {
            if ($admin["failedAttempt"] < 2) {
                update_admin_attempt($conn, $admin["id"], $admin["failedAttempt"] + 1);
                return [
                    "errorMsg"  => "Incorrect username or password.",
                    "adminId"   => null,
                ];
            }

            # Block account if there are 3 failed attempts
            block_admin($conn, $admin["id"]);
            update_admin_attempt($conn, $admin["id"], 0);
            return [
                "errorMsg"  => "The account has been temporarily blocked. Try again in 15 minutes.",
                "adminId"   => null,
            ];
        }

        # Reset the number of failed attempts
        if ($admin["failedAttempt"] != 0)
            update_admin_attempt($conn, $admin["id"], 0);

        return [
            "errorMsg"  => null,
            "adminId"   => $admin["id"],
        ];
    }

    $conn = get_conn();
    if ($conn) {
        create_user_table($conn);
        create_attempt_table($conn);
        create_admin_table($conn);
        populate_admin_table($conn);
        mysqli_close($conn);
    }
?>