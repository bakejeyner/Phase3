<?php

  seesion_start();

  $_SESSION["location_id"] = $_POST["location_id"];

  $result = true;
  echo json_encode($result);

?>