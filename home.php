<?php
  session_start();

  if(!isset($_SESSION["username"])){
    window.location.href='http://unstoppabledesignstudio.com/index.php';
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Game Rental</title>
    <script src="https://unpkg.com/react@latest/dist/react.js"></script>
    <script src="https://unpkg.com/react-dom@latest/dist/react-dom.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
  <link rel="stylesheet" href="styles.css">
    <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

  <body style="background-color:rgba(10,11,49,1.00)">

    <div class="container">
      <div class="row">
        <div class="span12" style="position: relative; background-color:maroon; width: 100%; top: 100px; height: 100px; display: table;">
          <h1 style="text-align:center; color: white;">Flash Game Rental</h1>
        </div>
      </div>
    </div>
    
    <h1 style="position: absolute; color: orange; top: 200px; left: 35%;">You made it to the home page</h1>

    <form class="form-inline" method="post" name="filter">
      <div class="form-group" style="background-color: rgba(27,24,24,1.00);position: relative; display:inline-block; vertical-align:middle; float:none; width: 100%; margin-left:auto; margin-right:auto; top:15px; height: 170px;">
        <label for="filter-name" class="title" style="color: white; top: 10px; width: 100%">Name:</label>
        <input type="text" class="form-control" id="filter-name" style="width: 100%;" name="filter-name">
        <label for="filter-genre" class="title" style="color: white; top: 10px; width: 100%">Genre:</label>
        <input type="text" class="form-control" id="filter-genre" style="width: 100%;" name="filter-genre">
        <label for="filter-city" class="title" style="color: white; top: 10px; width: 100%">Name:</label>
        <input type="text" class="form-control" id="filter-city" style="width: 100%;" name="filter-city">
      </div>
      <button id="finish" type="submit" name="filter-submit" class="btn btn-default" style="position: relative; color:white; top: 25px; margin-left: 46%; width: 100px; background-color: rgb(38, 44, 52); border: none;">Submit</button>
    </form>

    <h1>Distribution Centers</h1>
    <table class="table-inline" id="filter-table-distribution">
      <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Genre</th>
        <th>Did</th>
        <th>City</th>
        <th>Quantity</th>
        <th>Available</th>
        <th>Rent Now!</th>
      </tr>
    </table>

    <h1>Stores</h1>
    <table class="table-inline" id="filter-table-store">
      <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Genre</th>
        <th>Sid</th>
        <th>City</th>
        <th>Quantity</th>
        <th>Available</th>
      </tr>
    </table>

    <button type='button' id='my-account-button' class="btn btn-default">My Account</button>


    <!-- Start of script -->


    <script>

      //php to set filter parameters
      <?php

        //use the form paramters
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
          echo "var name = {$_POST["name"]};";
          echo "var genre = {$_POST["genre"]};";
          echo "var city = {$_POST["city"]};";
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
            G.name, G.price, G.genre, G.did, L.city, G.quantity, G.numRented
            
            for (i = 0, i < data.length; i++)
            {
              //if a distribution center
              if (data[i][3] > 20)
              {
                $("#filter-table-distribution").append("<tr>");
                $("#filter-table-distribution").append("<td>" + data[i][0] + "</td>"); //name
                $("#filter-table-distribution").append("<td>" + data[i][1] + "</td>"); //price
                $("#filter-table-distribution").append("<td>" + data[i][2] + "</td>"); //genre
                $("#filter-table-distribution").append("<td><span class='location-id'" + data[i][3] + "</span></td>"); //did
                $("#filter-table-distribution").append("<td>" + data[i][4] + "</td>"); //city
                $("#filter-table-distribution").append("<td>" + data[i][5] + "</td>"); //quantity
                $("#filter-table-distribution").append("<td>" + (data[i][5] - data[i][6]) + "</td>"); //available

                //make button only if there are available copies
                if (data[i][5] - data[i][6] === 0) {
                  $("#filter-table-distribution").append("<td><button type='button' class='rent-now-button' data-did='" + data[i][3] + "' data-name='" + data[i][0] + "'  >Rent Now!</button></td>"); //Rant Now!
                }
                $("#filter-table-distribution").append("</tr>");
              }

              //if a store
              else
              {
                $("#filter-table-store").append("<tr>");
                $("#filter-table-store").append("<td>" + data[i][0] + "</td>"); //name
                $("#filter-table-store").append("<td>" + data[i][1] + "</td>"); //price
                $("#filter-table-store").append("<td>" + data[i][2] + "</td>"); //genre
                $("#filter-table-store").append("<td><span class='location-id'" + data[i][3] + "</span></td>"); //sid
                $("#filter-table-store").append("<td>" + data[i][4] + "</td>"); //city
                $("#filter-table-store").append("<td>" + data[i][5] + "</td>"); //quantity
                $("#filter-table-store").append("<td>" + (parseInt(data[i][5]) - parseInt(data[i][6])) + "</td>"); //available
                $("#filter-table-store").append("</tr>");
              }
            }

          }
        })
      })




      //location id clicks
      $(".location-id").click(function() {
        $.ajax({
          url: "insertOrder.php",
          type: "POST",
          data: {"location_id": parseInt($(this).innerText())},
          datatype: 'json',

          success: function(data) {
            window.location.href='http://unstoppabledesignstudio.com/location.php';
          }
        })
      })

      //Rent Now! onlclick
      $(".rent-now-button").click(function() {
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
        })
      })



      //my account click
      $("#my-account-button").click(function() {
        window.location.href='http://unstoppabledesignstudio.com/my-account.php';
      })

    </script>

  </body>
</html>
