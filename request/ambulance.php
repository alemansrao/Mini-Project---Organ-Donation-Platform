<?php
include "../db.php";
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../");
}

$selectQuery = "SELECT * FROM user_table NATURAL JOIN details_table where username='" . $_SESSION['username'] . "';";
// echo $selectQuery;
$result = mysqli_query($conn, $selectQuery);
if ($result) {

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $userid = $row["username"];
            $email = $row["email"];
            $address = $row["address"];
            $pincode = $row["pincode"];
            $phone = $row["phone"];
            $fafa = "../" . $row["file_path"];
            $name = $row["name"];
        }
    } else {
        echo "0 results";
    }
}
if (isset($_POST['submit'])) {
    $enteredAddress = $_POST['address'];
    $enteredPhone = $_POST['phone'];
    $reqID = $userid . "_Ambulance";
    $insertQuery = "insert into requests_table values('$reqID','$userid','$email','Ambulance','$name','$enteredAddress','$pincode',$enteredPhone,'" . date("Y-m-j") . "');";
    // echo $insertQuery;
    if (mysqli_query($conn, $insertQuery)) {
        $msg = "Name : $name\nAddress : $address\nPincode : $pincode\nContact No : $phone";
        $mailSent = mail(getAllEmail("Ambulance"), "Ambulance Needed Urgent", $msg);
        if ($mailSent) {
            output("All the drivers has been alerted by email");
        }
        else{
            output("Mail Not Sent");
        }
    } else if (mysqli_errno($conn) == 1062) {
        output("You Have already requested!<br> Please wait for Driver's response");
    } else {
        output("Error: " . $insertQuery . "<br>" . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Look for Volunteer</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="shortcut icon" href="../resources/heart.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/eye.css">
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
                    <a class="nav-link" href="../dashboard.php">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Look for donors
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./eye.php">Eye</a>
                        <a class="dropdown-item" href="./blood.php">Blood</a>
                        <a class="dropdown-item" href="./organ.php">Other</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Look for services
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="./doctor.php">Looking for a Doctor</a>
                        <a class="dropdown-item" href="./volenteer.php">Looking for a Volunteer</a>
                        <a class="dropdown-item" href="./ambulance.php">Looking for an ambulance</a>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../requests.php">All Requests</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle navbar-brand" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $name; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../info.php">My Info</a>
                        <a class="dropdown-item" href="?logout=True">Logout</a>
                    </div>
                </li>
                <a class="navbar-brand" href="#">
                    <img id="avatar" src="<?php echo $fafa; ?>" width="40" height="40" alt="">
                </a>
            </ul>
        </div>
    </nav>
    <div class="container">
        <form action="" method="post">
            <div class="input-group mb-3 ">
                <div class="input-group-prepend">
                    <span class="input-group-text">User Name</span>
                </div>
                <input type="text" class="form-control" placeholder="Username" aria-label="Username" disabled value="<?php echo $userid; ?>">
            </div>
            <div class="input-group mb-3 ">
                <div class="input-group-prepend">
                    <span class="input-group-text">Looking for</span>
                </div>
                <input type="text" class="form-control" placeholder="eye" aria-label="Username" value="&#128657; Ambulance" disabled>
            </div>
            <div class="input-group mb-3 ">
                <div class="input-group-prepend">
                    <span class="input-group-text">My contact Address</span>
                </div>
                <input type="text" name="address" class="form-control" placeholder="eye" aria-label="Username" value="<?php echo $address; ?>">
            </div>
            <div class="input-group mb-3 ">
                <div class="input-group-prepend">
                    <span class="input-group-text">My Contact No.</span>
                </div>
                <input type="text" name="phone" class="form-control" placeholder="eye" aria-label="Username" value="<?php echo $phone; ?>">
            </div>

            <button id="submitbtn" type="submit" name="submit" class="btn btn-primary">Send notification</button>
        </form>

    </div>
</body>

</html>