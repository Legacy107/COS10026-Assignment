<?php
    include_once "db_settings.php";

    # Gets a connection to the MySQL database using the config variables. Returns null if it can't connect.
    function get_conn() {
        GLOBAL $host, $user, $pwd, $sql_db;
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
            password VARCHAR(30) NOT NULL,
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
            firstName VARCHAR(30) NOT NULL,
            lastName VARCHAR(30) NOT NULL,
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
        $query = "INSERT INTO attempts (id, firstname, lastname)
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
            (NULL, 'orson_routt', 'password1'),
            (NULL, 'quoc_mai', 'password2'),
            (NULL, 'peter_farmer', 'password3'),
            (NULL, 'keath_kor', 'password4'),
            (NULL, 'yong_yuan', 'password5')";
        try {
            mysqli_query($conn, $query);
        } catch (Exception $_ex) {
            return false;
        }
        return true;
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
