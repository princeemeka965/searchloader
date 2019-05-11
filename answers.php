<?php
header("Access-Control-Allow-Origin: *");
$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

$servername = "localhost";
$username = "anyanwu";
$password = "1993bc";
$dbname = "qa";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}



$value = $_GET['msg'];


if($value == "")
{
     
 
}

 else if($value != "")  
{
$sql = "SELECT * FROM users WHERE id='$value'";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0)
 {
    // output data of each row
    while($row = mysqli_fetch_array($result))
     {
          $id = $row['id'];
         $firstname = $row['firstname'];
         $lastname = $row['lastname'];
         $photos = $row['photo'];
         $nation = $row['nation'];
         $state = $row['state'];
         $address = $row['address'];
         $mobile = $row['mobile'];
         $email = $row['email'];

              $res['items'] = array(["id" => $id, "firstname" => $firstname, "lastname" => $lastname, "photos" => $photos, "nation" => $nation, "state" => $state,
              "address" => $address, "mobile" => $mobile, "email" => $email]);
     }
          echo json_encode($res);



}
else
{
    $result['error'] = array(["message" => "No Results found"]);

    echo json_encode($result);
}
}


