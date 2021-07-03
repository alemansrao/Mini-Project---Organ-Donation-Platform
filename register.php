<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/register.css">
    <link rel="shortcut icon" href="./resources/heart.png" type="image/x-icon">
    <title>Register</title>
</head>
<?php
include "db.php";
if (isset($_POST['submit'])) {
    $userid = $_POST['userid'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass_hash = md5($password);
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $phone = $_POST['phone'];
    $isDonor = (isset($_POST['isDonor']) && $_POST['isDonor'] == 'True') ? "Yes" : "No";
    $isVolunteer = (isset($_POST['isVolunteer']) && $_POST['isVolunteer'] == 'True') ? "Yes" : "No";
    $isDoctor = (isset($_POST['isDoctor']) && $_POST['isDoctor'] == 'True') ? "Yes" : "No";
    $isAmbulance = (isset($_POST['isAmbulance']) && $_POST['isAmbulance'] == 'True') ? "Yes" : "No";
    //image
    if (isset($_FILES['imgFile'])) {

        $errors = array();
        $file_name = $_FILES['imgFile']['name'];
        $file_size = $_FILES['imgFile']['size'];
        $file_tmp = $_FILES['imgFile']['tmp_name'];
        $file_type = $_FILES['imgFile']['type'];
        $exp = explode('.', $_FILES['imgFile']['name']);
        $file_ext = strtolower(end($exp));
        $hash_of_image = md5(time()) . "." . $file_ext;
        $file_location = "images/$hash_of_image";
        $extensions = array("jpeg", "jpg", "png");
        if (empty($errors) == true) {
            move_uploaded_file($file_tmp, $file_location);
        } else {
            print_r($errors);
        }
    }
    //inserting into user_table
    $insertQuery = "insert into user_table values('$userid','$pass_hash');";
    if (mysqli_query($conn, $insertQuery)) {
        header("Location: ./index.php?registered=True");
        output("New record created successfully <a href=\"./index.php\">Click Here to Login</a>");
    } else if (mysqli_errno($conn) == 1062) {
        output("User Already exists <a href=\"./index.php\">Click Here to Login</a>");
    } else {
        output("Error: " . $sql . "<br>" . mysqli_error($conn));
    }

    //inserting into details_table
    $insertDetails = "insert into details_table values('$userid','$name','$email','$gender','$address','$pincode','$phone','$isDonor','$isVolunteer','$isDoctor','$isAmbulance','$file_location');";
    if (mysqli_query($conn, $insertDetails)) {
        // output("sdfkjsdfkjshdjkfshkdfhsdfskdjfhskdfhksdfhs");
    } else {
        // output("Error");
    }
}
?>

<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <span class="input-group-text" id="userid">Enter Name</span>
                <input required type="text" class="form-control" placeholder="Enter name" aria-label="Enter name" name="name" maxlength="25">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="userid">Enter Adhaar Number</span>
                <input required type="text" class="form-control" placeholder="Aadhaar number" aria-label="Aadhaar number" name="userid" maxlength="12">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="password">Set password</span>
                <input required type="password" class="form-control" placeholder="Set password" aria-label="Set password" name="password">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="userid">Enter Email</span>
                <input required type="email" class="form-control" placeholder="Email Address" aria-label="Email Address" name="email">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender1" checked value="Male">
                <label class="form-check-label" for="gender1">
                    Male
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender1" value="Female">
                <label class="form-check-label" for="gender1">
                    Female
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender1" value="Other">
                <label class="form-check-label" for="gender1">
                    Other
                </label>
            </div>
            <div class="input-group mb-3" id="paUp">
                <span class="input-group-text" id="age">Enter age</span>
                <input required type="number" class="form-control" placeholder="Enter age" aria-label="Enter age" name="age">
            </div>
            <div class="input-group  mb-3">
                <span class="input-group-text">Address</span>
                <textarea class="form-control" aria-label="Enter address" placeholder="Enter address" name="address"></textarea>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text" id="pincode">Enter pincode</span>
                <input required type="number" class="form-control" placeholder="Enter pincode" aria-label="Enter pincode" name="pincode">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="phonr">Enter Phone No. +91</span>
                <input required type="number" class="form-control" placeholder="Enter Phone No." name="phone">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="True" id="flexCheckDefault" checked name="isDonor">
                <label class="form-check-label" for="flexCheckDefault">
                    I'm a Donor
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="True" id="flexCheckDefault" name="isVolunteer">
                <label class="form-check-label" for="flexCheckDefault">
                    I'm a Volunteer to help
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="True" id="flexCheckDefault" name="isDoctor">
                <label class="form-check-label" for="flexCheckDefault">
                    I'm a Doctor
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="True" id="flexCheckDefault" name="isAmbulance">
                <label class="form-check-label" for="flexCheckDefault">
                    I'm an Ambulance driver
                </label>
            </div>
            <div class="input-group mb-3" id="paUp">
                <input required type="file" class="form-control" id="photo" name="imgFile" accept="image/*">
                <label class="input-group-text" for="photo">Upload</label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary" id="submit">Register</button>
            <h6 id="userExists">&#128683;User Already exists</h6>
        </form>
    </div>
</body>

</html>