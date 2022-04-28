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
    <?php include('header.inc')
    ?>

    <main class="manage-main">
        <h1>Manage Attempts</h1>
        <form method="post" action="">
          <fieldset id="manage__controls">
            <div>
              <label for="fname">First Name</label>
              <input type="text" id="fname" name="fname"/>
            </div>
            <div>
              <label for="fname">Last Name</label>
              <input type="text" id="lname" name="lname"/>
            </div>
            <div>
              <label for="fname">Student ID</label>
              <input type="text" id="sid" name="sid"/>
            </div>
            <div>
              <label for="presets">Presets</label>
              <select id="presets" name="presets">
                <option value="all">All</option>
                <option value="100_first">100% on first attempt</option>
                <option value="less_50_second">&lt;50% on second attempt</option>
              </select>
            </div>
          </fieldset>
          <input type="submit" value="Filter"/>
          <input type="submit" value="Delete Attempts" id="manage__delete" formaction=""/>
        </form>

        <h2>List of Attempts</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Score</th>
                <th>Action</th>
            </tr>
            <tr>
                <form method="post" action="">
                    <td>123456789</td>
                    <td>John Doe</td>
                    <td>05:00 24/04/2022</td>
                    <td><input type="number" value="100"/></td>
                    <td><input type="submit" value="Edit"/></td>
                </form>
            </tr>
        </table>
    </main>
    <?php include('footer.inc')
    ?>
   
</body>
</html>
