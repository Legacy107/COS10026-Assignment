<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Creating Web Applications Lab 10"/>
<meta name="Keath Kor" content="PHP, My SQL" />
<title>Retrieving records to HTML</title>
</head> 
<body>
<h1>Creating Web Applications - Lab10</h1>
<?php 
    require_once ("Settings.php");

    $conn = @mysqli_connect($host,
        $user,
        $pwd,
        $sql_db);
    
    if (!$conn) {

        echo "<p>Database connection failure</p>";
    } else {
        $sql_table="cars";
    }

        $query = "select make, model, price FROM cars ORDER by make, model";

        $result = mysqli_query($conn, $query);

        if(!$result) {
            echo "<p>Something is wrong with ", $query, "</p>";
        } else {
            echo "<table border=\"1\">\n";
        } else {}
            echo "<table border=\"1\">\n";
            echo "<tr>\n "
           ."<th scope=\"col\">Make</th>\n "
           ."<th scope=\"col\">Model</th>\n "
           ."<th scope=\"col\">Price</th>\n "
           ."</tr>\n ";

    } 
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>\n ";
        echo "<td>",$row["make"],"</td>\n ";
        echo "<td>",$row["mode"],"</td>\n ";
        echo "<td>",$row["price"],"</td>\n ";
        echo "</tr>\n ";
    }
    echo "</table>\n ";
    mysqli_free_result($result);
}

    mysqli_close($conn);
?>
</body>
</html>