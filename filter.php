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
  $sql_distribution= <<<EOT
    SELECT G.name, G.price, G.genre, G.did, L.city, G.quantity, G.numRented 
    FROM games_in_dist G, distribution_center_location L 
    WHERE 
    G.did = L.did 
EOT;

  if ($_POST["name"] !== "null") {
    $sql_distribution .= " AND G.name = '" . $_POST["name"] . "'";
  }

  if ($_POST["genre"] !== "null") {
    $sql_distribution .= " AND G.genre = '" . $_POST["genre"] . "'";
  }

  if ($_POST["city"] !== "null") {
    $sql_distribution .= " AND L.city = '" . $_POST["city"] . "'";
  }



  $sql_store = <<<EOT
    SELECT G.name, G.price, G.genre, G.did, L.city, G.quantity, G.numRented 
    FROM games_in_dist G, store_location L 
    WHERE 
    G.did = L.did
EOT;

  if ($_POST["name"] !== "null") 
  {
    $sql_store .= " AND G.name = '" . $_POST["name"] . "'";
  }

  if ($_POST["genre"] !== "null") {
    $sql_store .= " AND G.genre = '" . $_POST["genre"] . "'";
  }

  if ($_POST["city"] !== "null") {
    $sql_store .= " AND L.city = '" . $_POST["city"] . "'";
  }


  //results
  $result_distribution = $conn->query($sql_distribution);
  if($conn->connect_error)
  {
    die("Result query failed: ". $conn->connect_error);
  }

  $result_store = $conn->query($sql_store);
  if($conn->connect_error)
  {
    die("Store query failed: ". $conn->connect_error);
  }

  //array to push to
  $result = [];

  while ($row = $result_distribution->fetch_assoc())
  {
    $result[] = $row;
  }

  while ($row = $result_store->fetch_assoc())
  {
    $result[] = $row;
  }

  header('Content-Type: application/json');
  echo json_encode($result);

 ?>