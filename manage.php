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
    <?php include('header.inc')?>

    <main id="manage-main">
        <h1 id="manage__mainheading">Manage Attempts</h1>
        <form id="manage__filter" method="post" action="manage.php?action=filter">
            <fieldset id="manage__filters">
                <div class="manage__filterarea">
                    <h4>
                        <label class="manage__label" for="fname">First Name</label>
                    </h4>
                    <input type="text" id="fname" class="manage__textinput" name="fname" pattern="^[a-zA-Z\s-]{0,30}$" title="Please enter upper or lower case letters only, spaces are allowed. Maximum 30 characters"/>
                </div>
                <div class="manage__filterarea">
                    <h4>
                        <label class="manage__label" for="fname">Last Name</label>
                    </h4>
                    <input type="text" id="lname" class="manage__textinput" name="lname" pattern="^[a-zA-Z\s-]{0,30}$" title="Please enter upper or lower case letters only, spaces are allowed. Maximum 30 characters"/>
                </div>
                <div class="manage__filterarea">
                    <h4>
                        <label class="manage__label" for="fname">Student ID</label>
                    </h4>
                    <input type="text" id="sid" class="manage__textinput" name="sid" pattern="^(\d{7}|\d{10})?$" title="Please enter 7 or 10 digits."/>
                </div>
                <br/>
                <div class="manage__filterarea">
                    <h4>
                        <label class="manage__label" for="filter">Filter Options</label>
                    </h4>
                    <select id="filter" name="filter">
                        <option value="all">All</option>
                        <option value="name">By name</option>
                        <option value="sid">By student ID</option>
                        <option value="100_first">100% on first attempt</option>
                        <option value="less_50_second">&lt;50% on second attempt</option>
                    </select>
                </div>
            </fieldset>
            <br/>
            <input type="submit" class="manage-submit" value="Filter"/>
        </form>

        <h2 id="manage__listheading">List of Attempts</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Score</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>123456789</td>
                <td>John Doe</td>
                <td>05:00 24/04/2022</td>
                <form method="post" action="manage.php?action=edit">
                    <input type="hidden" name="attempt" value="AID"/>
                    <td><input type="number" class="manage-score" name="attempt_value" min="0" max="6" value="6" required/></td>
                    <td><input type="submit" class="manage-edit" value="Edit"/></td>
                </form>
            </tr>
            <tr>
                <td>123456789</td>
                <td>John Doe</td>
                <td>05:00 24/04/2022</td>
                <form method="post" action="manage.php?action=edit">
                    <input type="hidden" name="attempt" value="AID"/>
                    <td><input type="number" class="manage-score" name="attempt_value" min="0" max="6" value="6" required/></td>
                    <td><input type="submit" class="manage-edit" value="Edit"/></td>
                </form>
            </tr>
            <tr>
                <td>123456789</td>
                <td>John Doe</td>
                <td>05:00 24/04/2022</td>
                <form method="post" action="manage.php?action=edit">
                    <input type="hidden" name="attempt" value="AID"/>
                    <td><input type="number" class="manage-score" name="attempt_value" min="0" max="6" value="6" required/></td>
                    <td><input type="submit" class="manage-edit" value="Edit"/></td>
                </form>
            </tr>
        </table>

        <form method="post" action="manage.php?action=delete">
            <input type="submit" id="manage__delete" class="manage-submit" value="Delete Attempts"/>
        </form>
    </main>
    
    <form method="post" action="logout.php">
        <input type="submit" id="manage__logout" class="manage-submit" value="Logout"/>
    </form>

    <?php include('footer.inc')?>
</body>
</html>
