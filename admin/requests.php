<?php
session_start();
include "../db.php";
if (!isset($_SESSION['username'])) {
    #Not logged-in
    header('Location: ../index.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../");
}


$selectQuery = "SELECT * FROM admin_table where username='" . $_SESSION['username'] . "';";
// echo $selectQuery;
$result = mysqli_query($conn, $selectQuery);
if ($result) {

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            // $fafa = $row["file_path"];
            // $name = $row["name"];
            // $username = $row["username"];
            // $pincode = $row['pincode'];
        }
    } else {
        echo "0 results";
    }
}


if (isset($_GET['cancel'])) {
    $deleteRequests = "delete from requests_table where username='$username';";
    $result2 = mysqli_query($conn, $deleteRequests);
    if($result2)
    {
        if(mysqli_affected_rows($conn)>0){
            output("All your Requests has been deleted !");
        }
        else
        {
            output("You have no Request !");
        }
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
    <link rel="shortcut icon" href="../resources/heart.png" type="image/x-icon">
    <title>Requests</title>
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
                        <a class="dropdown-item" href="?logout=True">Logout</a>
                    </div>
                </li>
                <!-- <a class="navbar-brand" href="#">
                    <img id="avatar" src="<?php echo $fafa; ?>" width="40" height="40" alt="">
                </a> -->
            </ul>
        </div>
    </nav>
    <!-- <div class="container"> -->
    <style>
        body {
            background-color: #2e343a;
        }

        table {
            max-width: 100vw;
        }
    </style>
    <table class="table table-bordered table-dark">
        <thead>
            <tr>
                <th scope="col">Requested for</th>
                <th scope="col">Name</th>
                <!-- <th scope="col">Address</th> -->
                <th scope="col">Contact No.</th>
                <th scope="col">Requested on</th>
            </tr>
        </thead>
        <tbody>
            


                <?php
                function td($str)
                {
                    echo "<td>$str</td>";
                }

                $selectRequests = "select * from requests_table order by date";
                $result1 = mysqli_query($conn, $selectRequests);
                if ($result1) {
                    if (mysqli_num_rows($result1) > 0) {
                        // output data of each row
                        while ($row = mysqli_fetch_assoc($result1)) {
                            echo "<tr>";
                            td($row['organ_requested']);
                            td($row["name"]);
                            // td($row["address"]);
                            td($row["phone"]);
                            td(date("d-F-Y", strtotime($row["date"])));
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        td("None");
                        td("None");
                        td("None");
                        td("None");
                        echo "</tr>";
                    }
                }


                ?>



            

        </tbody>
    </table>
    <!-- </div> -->
</body>

</html>