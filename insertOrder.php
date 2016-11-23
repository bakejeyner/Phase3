<?php

  session_start();


  $servername= "localhost";
  $username= "unstopq7_admin";
  $password= "db@dmin23";
  $db= "unstopq7_gameRental";

  $conn = new mysqli($servername, $username, $password, $db);

  if($conn->connect_error)
  {
    die("Connection failed: ". $conn->connect_error);
  }

  //make the sql strings
  $sql = <<<EOT
  INSERT INTO ORDERS (username, did, name, day_recieved, day_returned)
  VALUES ({$_SESSION["username"]}, {$_POST["did"]}, {$_POST["name"]}, now(), NULL)
EOT;

  $conn->query($sql);

  $result = true;
  echo json_encode($result);

?>