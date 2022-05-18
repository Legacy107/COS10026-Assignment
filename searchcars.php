<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta name="description" content="Creating web application lab 10">
	<meta name="keywords" content="PHP, MySQL">
	<title>Search result</title>
</head>
<body>
	<h1>Creating web application - lab 10</h1>
	<?php
		function sanitise_input($data){
			$data = trim($data);			
			$data = stripslashes($data);		
			$data = htmlspecialchars($data);	
			return $data;
		}


		if (isset($_POST["carmake"])){	
		
			$make = sanitise_input($_POST["carmake"]);
			$model = sanitise_input($_POST["carmodel"]);
			$price = sanitise_input($_POST["price"]);
			$yom = sanitise_input($_POST["yom"]);

		
			$condition = "";
			if ($make != "")		
				$condition .= "make='$make'";
			if ($model != ""){
				if ($condition != "")
					$condition .= "and model='$model'";
				else
					$condition .= "model='$model'";
			}
			if ($price != ""){
				if ($condition != "")
					$condition .= "and price='$price'";
				else
					$condition .= "price='$price'";
			}
			if ($yom != ""){
				if ($condition != "")
					$condition .= "and yom='$yom'";
				else
					$condition .= "yom='$yom'";
			}



			require_once("settings.php");	
			$conn = @mysqli_connect($host,$user,$pwd,$sql_db);	
			$sql_table = "cars";	
			$query = "select * from $sql_table where $condition;";		
			$result = mysqli_query($conn, $query);	
			if (!$result){		
				echo "<p class='wrong'>Something is wrong with ", $query, "</p>";
			}
			else{	
				echo "<table border='1'>";
				echo "<tr>
							<th scope='col'>Make</th>
							<th scope='col'>Model</th>
							<th scope='col'>Price</th>
							<th scope='col'>Year</th>
					  </tr>";
				while ($record = mysqli_fetch_assoc($result)){		
					echo "<tr>\n";
					echo "<td>", $record["make"], "</td>\n";
					echo "<td>", $record["model"], "</td>\n";
					echo "<td>", $record["price"], "</td>\n";
					echo "<td>", $record["yom"], "</td>\n";
					echo "</tr>\n";
				}
				echo "</table>";
				mysqli_free_result($result);	
			}
			mysqli_close($conn);	
		}
		else{
			header("location: searchcar.html");		
		}
	?>
</body>
</html>