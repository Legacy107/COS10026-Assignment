<?php
    // MariaDB config
    // TODO: replace with team's DB
    $host = "feenix-mariadb.swin.edu.au";
    $user = "s103532920";
    $pwd = "";
    $sql_db = "s103532920_db";

    /**
     * Get SQL connection
     * @return bool false if failed to connect
     * @return Object $conn 
     */
    function get_conn() {
        global $host, $user, $pwd, $sql_db;
        $conn = @mysqli_connect(
            $host,
            $user,
            $pwd,
            $sql_db
        );

        // Checks if connection is successful
        if (!$conn) {
            error_log("Failed to connect to MySQL: (" . mysqli_connect_errno() . ") " . mysqli_connect_error());
            return false;
        } else {
            return $conn;
        }
    }

    /**
     * Create User table if not exists
     * @return bool true if succesfully executed the query
     */
    function create_user_table() {
        $conn = get_conn();
        if (!$conn) {
            return false;
        }
        $query = "CREATE TABLE IF NOT EXISTS User (
            id INT NOT NULL,
            firstName VARCHAR(30) NOT NULL,
            lastName VARCHAR(30) NOT NULL,
            CHECK ((1000000 <= id AND id <= 9999999) OR (10000000 <= id AND id <= 99999999)),
            PRIMARY KEY (id)
        )";
        $result = mysqli_query($conn, $query);
        
        if (!$result) {
            error_log(
                "Failed to create User table: (" .
                mysqli_errno($conn) . ") " .
                mysqli_error($conn)
            );
        }
        mysqli_close($conn);
        return (bool)$result;
    }

    /**
     * Create Admin table if not exists
     * @return bool true if succesfully executed the query
     */
    function create_admin_table() {
        $conn = get_conn();
        if (!$conn) {
            return false;
        }
        $query = "CREATE TABLE IF NOT EXISTS Admin (
            id INT NOT NULL AUTO_INCREMENT,
            username VARCHAR(30) NOT NULL UNIQUE,
            password VARCHAR(30) NOT NULL,
            CHECK (LENGTH(password) > 8),
            PRIMARY KEY (id)
        )";
        $result = mysqli_query($conn, $query);
        
        if (!$result) {
            error_log(
                "Failed to create Admin table: (" .
                mysqli_errno($conn) . ") " .
                mysqli_error($conn)
            );
        }
        mysqli_close($conn);
        return (bool)$result;
    }

    /**
     * Create Attempt table if not exists
     * @return bool true if succesfully executed the query
     */
    function create_attempt_table() {
        $conn = get_conn();
        if (!$conn) {
            return false;
        }
        $query = "CREATE TABLE IF NOT EXISTS Attempt (
            id INT NOT NULL AUTO_INCREMENT,
            userId INT,
            score TINYINT DEFAULT 0,
            dateCreated	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            dateUpdated	TIMESTAMP,
            PRIMARY KEY (id),
            FOREIGN KEY (userId) REFERENCES User(id)
        )";
        $result = mysqli_query($conn, $query);
        
        if (!$result) {
            error_log(
                "Failed to create Attempt table: (" .
                mysqli_errno($conn) . ") " .
                mysqli_error($conn)
            );
        }
        mysqli_close($conn);
        return (bool)$result;
    }
?>