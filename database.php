<?php
    // MariaDB config variables.
    $host = "feenix-mariadb.swin.edu.au";
    $user = "s103575527";
    $pwd = "311002";
    $sql_db = "s103575527_db";
    # Details for Orson's database.
    # Has [orson_routt, long_password] and [admin, not_admin] as logins.

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
            id INT NOT NULL,
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
            userId INT NOT NULL,
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
?>