<?php

  session_start();

  //stripping function
  function stripping($data)
  {
    $data= trim($data);
    $data= stripslashes($data);
    $data = htmlspecialchars($data);
    return ($data);
  }

  $uname = stripping($_SESSION["uname"]);
  $did = stripping($_POST["did"]);
  $name = stripping($_POST["name"]);

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
INSERT INTO Orders (username, did, name, day_received, day_returned)
VALUES ('{$uname}', '{$did}', '{$name}', now(), NULL)
EOT;

   $result = $conn->query($sql);

  if (!$result)
  {
    die("Insert failed: " . $conn->connect_error);
  }

  $result = true;
  echo json_encode($result);

?>