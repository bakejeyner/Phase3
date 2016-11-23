<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Game Rental</title>
    <script src="https://unpkg.com/react@latest/dist/react.js"></script>
    <script src="https://unpkg.com/react-dom@latest/dist/react-dom.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
    <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script scr="script.js"></script>
  </head>

  <body style="background-color:rgba(10,11,49,1.00)">
    <div class="container">
      <div class="row">
        <div class="span12" style="position: relative; background-color:maroon; width: 100%; top: 100px; height: 100px; display: table;">
          <h1 style="text-align:center; color: white;">Flash Game Rental</h1>
        </div>
      </div>
      <div class="row">
        <div class="span12 offset3" style="position: relative; background-color:maroon; top: 250px; height: 230px; width: 100%;">
          <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" name="sign-in">
            <div class="form-group" style="background-color: rgba(27,24,24,1.00);position: relative; display:inline-block; vertical-align:middle; float:none; width: 100%; margin-left:auto; margin-right:auto; top:15px; height: 170px;">
              <label for="usr" class="title" style="color: white; top: 10px; width: 100%">Username:</label>
              <input type="text" class="form-control" id="usr" style="width: 100%;" name="username" required>

              <label for="pwd" class="title" style="color: white; position: relative;top: 10px; width: 100%;">Password:</label>
              <input type="password" class="form-control" id="pwd" style="position:relative; top:10px; width: 100%;" name="password" required>
            </div>
            <button id="finish" type="submit" class="btn btn-default" style="position: relative; color:white; top: 25px; margin-left: 46%; width: 100px; background-color: rgb(38, 44, 52); border: none;">Submit</button>
          </form>
        </div>
      </div>
    </div>

    <!--                  php section here                    --->
    <?php
      $servername= "localhost";
      $username="unstopq7_admin";
      $password="db@dmin23";
	  $db="unstopq7_gameRental";

      $conn = new mysqli($servername, $username, $password, $db);

      if($conn->connect_error)
      {
        die("Connection failed: ". $conn->connect_error);
      }

      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        $username = stripping($_REQUEST["username"]);
        $password = stripping($_REQUEST["password"]);      		  
		
		$sql1 = "SELECT username FROM Users WHERE username = '$username'";//you want to match these usernames
		$sql2 = "SELECT username FROM Users WHERE password = '$password'";
		$result1 = $conn->query($sql1);
		$result2 = $conn->query($sql2);
		
		if($result1->num_rows > 0)
		{
			if($result2->num_rows > 0)
			{
				$row1 = $result1->fetch_assoc();
				$row2 = $result2->fetch_assoc();
				if($row1["username"] == $row2["username"])
				{
					$_SESSION["username"]=$row1["username"];
					echo "<script>window.location.href='http://unstoppabledesignstudio.com/home.php';</script>";
				}
				else
				{
					echo "<script>";
					echo "alert('Username and Password do not match');";
					echo "</script>";//throw alert
				}
			}
			else
			{
				echo "<script>";
					echo "alert('Password not in database');";
					echo "</script>";//throw alert
			}
		}
		else
		{
			echo "<script>";
			echo "alert('Username not in database');";
			echo "</script>";//throw alert
		}
	  }

      function stripping($data)
      {
        $data= trim($data);
        $data= stripslashes($data);
        $data = htmlspecialchars($data);
        return ($data);
      }


    ?>

  </body>
</html>
