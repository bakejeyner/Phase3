<?php
  session_start();

  if(!isset($_SESSION["username"])){
   echo "window.location.href='http://unstoppabledesignstudio.com/index.php'";
   //echo $_SESSION["username"];
  }
	//$uname = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Game Rental</title>
	<script src= "script.js"></script>
    <script src="https://unpkg.com/react@latest/dist/react.js"></script>
    <script src="https://unpkg.com/react-dom@latest/dist/react-dom.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
  <link rel="stylesheet" href="school.css">
    <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

  <body style="background-color:rgba(10,11,49,1.00)">

    <div class="container-fluid">
      <div class="row">
        <div class="span12" style="position: relative; background-color:maroon; width: 100%; height: 70px; display: table;">
          <h2 style="text-align:center; color: white;">Flash Game Rental</h2>
        </div>
      </div>
      <div class="row">
      <div class="col-sm-4">
        	<h6>.</h6>
        </div>
      	<div class="col-sm-4">
        	<button type='button' id='my-account-button' class="btn btn-default" onClick="toUser()" style="margin-left: 200px;">My Account</button>
        </div>
        <div class="col-sm-4">
        	<h6>.</h6>
        </div>
      </div>
    </div>
	<div style="height:50px;">.</div>
    <form class="form-inline" method="post" name="filter">
      <div class="form-group" style="background-color: rgba(27,24,24,1.00);position: relative; display:inline-block; vertical-align:middle; float:none; width: 100%; margin-left:auto; margin-right:auto; top:15px; height: 170px;">
        <label for="filter-name" class="title" style="color: white; top: 10px; width: 100%">Name:</label>
        <input type="text" class="form-control" id="filter-name" style="width: 100%;" name="filter-name">
        <label for="filter-genre" class="title" style="color: white; top: 10px; width: 100%">Genre:</label>
        <input type="text" class="form-control" id="filter-genre" style="width: 100%;" name="filter-genre">
        <label for="filter-city" class="title" style="color: white; top: 10px; width: 100%">City:</label>
        <input type="text" class="form-control" id="filter-city" style="width: 100%;" name="filter-city">
      </div>
      <button id="finish" type="submit" name="filter-submit" class="btn btn-default" style="position: relative; color:white; top: 25px; margin-left: 46%; width: 100px; background-color: rgb(38, 44, 52); border: none;">Submit</button>
    </form>

    <h1>Distribution Centers</h1>
    <table class="table-inline main" id="filter-table-distribution">
      <tr class="tr-main">
        <th class="th-main">Name</th>
        <th class="th-main">Price</th>
        <th class="th-main">Genre</th>
        <th class="th-main">Did</th>
        <th class="th-main">City</th>
        <th class="th-main">Quantity</th>
        <th class="th-main">Available</th>
        <th class="th-main">Rent Now!</th>
      </tr>
    </table>

    <h1>Stores</h1>
    <table class="table-inline main" id="filter-table-store">
      <tr class="tr-main">
        <th class="th-main">Name</th>
        <th class="th-main">Price</th>
        <th class="th-main">Genre</th>
        <th class="th-main">Sid</th>
        <th class="th-main">City</th>
        <th class="th-main">Quantity</th>
        <th class="th-main">Available</th>
      </tr>
    </table>


    <!-- Start of script -->


    <script>

      //php to set filter parameters
      <?php

        echo 'console.log("Current PHP version: ' . phpversion() . '");';

        //use the form paramters
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
          //name
          if ($_POST['name'] != ''){
            echo "var name = \"" . $_POST['name'] . "\";";
          }
          else echo "var name = \"null\";";

          //genre
          if ($_POST['genre'] != ''){
            echo "var genre = \"" . $_POST['genre'] . "\";";
          }
          else echo "var genre = \"null\";";

          //city
          if ($_POST['city'] != ''){
            echo "var city = \"" . $_POST['city'] . "\";";
          }
          else echo "var city = \"null\";";
        }

		    //use default parameters
        else
        {
          echo "var name = 'null';";
          echo "var genre = 'null';";
          echo "var city = 'null';";
        }

      ?>



      //start db call
      $(document).ready(function() {
        $.ajax({
          url: "filter.php",
          type: "POST",
          data: {"name": name, "genre": genre, "city": city},

          datatype: 'json',

          //make tables
          success: function(data)
          {

            var result = JSON.parse(data);

            for (i = 0; i < result.length; i++)
            {

              //if a distribution center
              if (result[i]['did'])
              {
                $("#filter-table-distribution").append("<tr class='tr-main' id='tr-" + i + "'>");
                $("#tr-" + i).append("<td class='td-main'>" + result[i]["name"] + "</td>"); //name
                $("#tr-" + i).append("<td class='td-main'>" + result[i]["price"] + "</td>"); //price
                $("#tr-" + i).append("<td class='td-main'>" + result[i]["genre"] + "</td>"); //genre
                $("#tr-" + i).append("<td class='td-main'><span class='location-id'>" + result[i]["did"] + "</span></td>"); //did
                $("#tr-" + i).append("<td class='td-main'>" + result[i]["city"] + "</td>"); //city
                $("#tr-" + i).append("<td class='td-main'>" + result[i]["quantity"] + "</td>"); //quantity
                $("#tr-" + i).append("<td class='td-main'>" + (parseInt(result[i]["quantity"]) - parseInt(result[i]["numRented"])) + "</td>"); //available

                //make button only if there are available copies
                if (result[i]["quantity"] - result[i]["numRented"] > 0) {
                  $("#tr-" + i).append("<td class='td-main'><button type='button' class='rent-now-button' data-did='" + result[i]["did"] + "' data-name='" + result[i]["name"] + "'  >Rent Now!</button></td>"); //Rant Now!
                }
                else {
                  $("#tr-" + i).append("<td class='td-main'>Sold Out!</td>"); //Rant Now!
                }

                $("#filter-table-distribution").append("</tr>");
              }

              //if a store
              else
              {
                $("#filter-table-store").append("<tr class='tr-main' id='tr-" + i + "'>");
                $("#tr-" + i).append("<td class='td-main'>" + result[i]["name"] + "</td>"); //name
                $("#tr-" + i).append("<td class='td-main'>" + result[i]["price"] + "</td>"); //price
                $("#tr-" + i).append("<td class='td-main'>" + result[i]["genre"] + "</td>"); //genre
                $("#tr-" + i).append("<td class='td-main'><span class='location-id'>" + result[i]["sid"] + "</span></td>"); //sid
                $("#tr-" + i).append("<td class='td-main'>" + result[i]["city"] + "</td>"); //city
                $("#tr-" + i).append("<td class='td-main'>" + result[i]["quantity"] + "</td>"); //quantity
                $("#tr-" + i).append("<td class='td-main'>" + (parseInt(result[i]["quantity"]) - parseInt(result[i]["numRented"])) + "</td>"); //available
                $("#filter-table-distribution").append("</tr>");
              }
            }
          },

          error: function(xhr, ajaxOptions, thrownError)
          {
            console.log('error');
          }
        });
      });




      //location id clicks
      $(".location-id").click(function(event) {
        $.ajax({
          url: "locationRedirect.php",
          type: "POST",
          data: {"location_id": parseInt($(this).text())},
          datatype: 'json',

          success: function(data) {
            window.location.href='http://unstoppabledesignstudio.com/location.php';
          }
        });
      });

      //Rent Now! onlclick
      $(".rent-now-button").click(function(event) {
        console.log('rent now button clicked');
        console.log(this);
        var did = parseInt($(this).attr("data-did"));
        var name = $(this).attr("data-name");

        //ajax insert
        $.ajax({
          url: "insertOrder.php",
          type: "POST",
          data: {"did": did, "name": name},
          datatype: 'json',

          success: function(data) {
            location.reload();
          }
        });
      });



      /*//my account click
      $("#my-account-button").click(function() {
        window.location.href='http://unstoppabledesignstudio.com/my-account.php';
      })*/

    </script>

  </body>
</html>