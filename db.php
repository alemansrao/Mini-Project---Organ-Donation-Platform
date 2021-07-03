<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'aleman');
define('DB_PASSWORD', '');
define('DB_NAME', 'adv_php');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn === false) {
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

function output($str)
{
  // echo "<h2 id=\"php\">$str</h2>";
  echo "<div class=\"info\"><h1>$str</h1></div>";
}

function getAllEmail($str)
{
  $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  $emailArray = array();
  switch ($str) {
    case "Doctor":
      $query = "select email from details_table where isDoctor='Yes'";
      break;
    case "Volunteer":
      $query = "select email from details_table where isVolunteer='Yes'";
      break;
    case "Ambulance":
      $query = "select email from details_table where isAmbulance='Yes'";
      break;
    default:
      $query = "select email from details_table where isDonor='Yes'";
  }
  $result = $conn->query($query);
  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      // echo $row['email'];
      array_push($emailArray,$row['email']);
    }
    // print_r($emailArray);
  } else {
    echo "0 results";
  }
  return implode(",",$emailArray);
}

?>
<style>
  .info {
    position: absolute;
    bottom: 20px;
    right: 20px;
    z-index: 15151515;
    color: #fff;
    width: 300px;
    border-radius: 15px;
    padding: 10px;
    background-color: #494949;
    word-wrap: break-word;
    text-align: center;
  }

  .info h1 {
    font-size: medium;

  }
</style>