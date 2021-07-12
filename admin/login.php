<?php
include "../db.php";
session_start();
$create = "create table if not exists user_table(username varchar(20) primary key,
    password varchar(40)
);";
if ($conn->query($create) === TRUE) {
    // echo "user_table created successfully";
}
if (isset($_SESSION['username'])) {
    // header('Location: ./dashboard.php');
}


$create1 = "create table if not exists admin_table(username varchar(20) primary key,
    password varchar(40)
);";
if ($conn->query($create1) === TRUE) {
}


$create = "create table if not exists details_table(
    username varchar(20) primary key,
    name varchar(25),
    email varchar(50),
    gender varchar(10),
    address varchar(100),
    pincode int(10),
    phone bigint(12),
    isDonor varchar(10),
    isVolunteer varchar(10),
    isDoctor varchar(10),
    isAmbulance varchar(10),
    file_path varchar(100)
);";
if ($conn->query($create) === TRUE) {
    // echo "details_table created successfully";
}



$create = "create table if not exists requests_table(
    request_id varchar(40) primary key,
    username varchar(20),
    email varchar(40),
    organ_requested varchar(20),
    name varchar(25),
    address varchar(100),
    pincode int(8),
    phone varchar(20),
    date date DEFAULT CURRENT_TIMESTAMP
);";
if ($conn->query($create) === TRUE) {
    // echo "details_table created successfully";
}
else{output(mysqli_error($conn));}



if (isset($_SESSION['username'])) {
    header('Location: ./dashboard.php');
}










#login

if (isset($_POST['submit'])) {

    $username = $_POST['userid'];
    $password = $_POST['password'];
    $pass_hash = md5($password);

    $checkUser = "select * from admin_table where username = '$username' and password = '$pass_hash';";
    $result = mysqli_query($conn, $checkUser);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['username'] = $username;
            // output data of each row
            // while ($row = mysqli_fetch_assoc($result)) {
            //     echo "id: " . $row["id"] . " - Name: " . $row["firstname"] . " " . $row["lastname"] . "<br>";
            // }
            header('Location: ./');
        } else {
            $invUser = "Yes";
        }
    } else {
        echo mysqli_error($conn);
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="shortcut icon" href="../resources/heart.png" type="image/x-icon">
    <title>Login</title>
</head>

<body>
    <div class="container" id="login">
    	<h1>Admin Login</h1>
    	<br>
        <form action="" method="post">
            <div class="mb-3">
                <label for="userid" class="form-label">Aadhaar No.</label>
                <input name="userid" type="text" class="form-control" id="userid" placeholder="Enter your Aadhaar No.">
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="pass" placeholder="Enter your Password">
            </div>
            <?php if (isset($invUser)) echo "<p style=\"color:red\">Invalid Credentials. Try Again</p>"; ?>
            <div class="mb-3">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <a href="../register.php">Click Here to register</a>
            </div>
        </form>
    </div>
</body>

</html>