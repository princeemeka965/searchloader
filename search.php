<?php

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
$sql = "SELECT * FROM users WHERE firstname LIKE '%$value%' OR lastname LIKE '%$value%'";
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

              $res['contents'] = array(["id" => $id, "firstname" => $firstname, "lastname" => $lastname, "photos" => $photos]);
     }
          echo json_encode($res);



}
else
{
    $result['error'] = array(["message" => "No Results found"]);

    echo json_encode($result);
}
}

