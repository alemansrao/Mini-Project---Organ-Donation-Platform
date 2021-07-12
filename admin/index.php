<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ./login.php");
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ./");
}
include "../db.php";







$selectQuery = "SELECT * FROM admin_table where username='" . $_SESSION['username'] . "';";
// echo $selectQuery;
$result = mysqli_query($conn, $selectQuery);
if ($result) {

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $fafa = $row["username"];
            // $name = $row["name"];
        }
    } else {
        echo "0 results";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="shortcut icon" href="../resources/heart.png" type="image/x-icon">
    <title>Dashboard</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="../resources/heart.png" width="30" height="30" alt="">
        </a>
        <a class="navbar-brand" href="#">Helping Hand</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="./">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        View users
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./index.php?view=Donor">Donor</a>
                        <a class="dropdown-item" href="./index.php?view=Doctor">Doctor</a>
                        <a class="dropdown-item" href="./index.php?view=Ambulance">Ambulance</a>
                        <a class="dropdown-item" href="./index.php?view=Volunteer">Volunteer</a>
                        <a class="dropdown-item" href="./index.php?view=All">All</a>
                    </div>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="./requests.php">All Requests</a>
                </li>

            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle navbar-brand" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['username']; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <!-- <a class="dropdown-item" href="./info.php">My Info</a> -->
                        <a class="dropdown-item" href="./index.php?logout=True">Logout</a>
                    </div>
                </li>
                <a class="navbar-brand" href="#">
                    <img id="avatar" src="https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png" width="40" height="40" alt="">
                    <style>
                        #avatar {
                            border-radius: 20px;
                        }
                    </style>
                </a>
            </ul>
        </div>
    </nav>







    <style>
        body {
            background-image: url("../resources/bg.jpg");
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>


    <?php
    if (!isset($_GET['view'])) {
        die();
    }
    ?>


    <table class="table table-bordered table-dark">
        <thead>
            <tr>
                <th scope="col">Profile picture</th>
                <th scope="col">UserName</th>
                <?php
                if ($_GET['view'] != "All")
                    echo "<th scope=\"col\">Registered as</th>";
                ?>
                <th scope="col">Phone</th>
                <th scope="col">Address</th>
                <th scope="col">Email</th>
                <th scope="col">Picode</th>
            </tr>
        </thead>
        <tbody>



            <?php
            function td($str)
            {
                echo "<td style='text-align:center; vertical-align:middle'>$str</td>";
            }
            if ($_GET['view'] == "All")
                $selectRequests = "select * from details_table order by username";
            else
                $selectRequests = "select * from details_table where is" . $_GET['view'] . "='yes' order by username";
            // echo $selectRequests;
            $result1 = mysqli_query($conn, $selectRequests);
            if ($result1) {
                if (mysqli_num_rows($result1) > 0) {
                    // output data of each row
                    while ($row = mysqli_fetch_assoc($result1)) {
                        echo "<tr>";
                        td("<img width=40 height=40 src='../" . $row['file_path'] . "'></img>"); //image
                        td($row["username"]);
                        if ($_GET['view'] != "All")
                            td($_GET['view']);
                        td($row["phone"]);
                        td($row["address"]);
                        td($row["email"]);
                        td($row["pincode"]);
                        // td(date("d-F-Y", strtotime($row["date"])));
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>";
                    td("None");
                    td("None");
                    td("None");
                    td("None");
                    td("None");
                    echo "</tr>";
                }
            } else {
                echo "<tr>";
                td("None");
                td("None");
                td("None");
                td("None");
                td("None");
                echo "</tr>";
            }


            ?>





        </tbody>
    </table>


</body>

</html>