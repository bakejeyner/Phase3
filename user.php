<?php session_start();
	if(!isset($_SESSION["username"]))
	{
   		echo "<script>window.location.href='http://unstoppabledesignstudio.com/index.php';</script>";
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

	<link rel="stylesheet" href="school.css">

    <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="script.js"></script>
  </head>

  <body style="background-color:rgba(10,11,49,1.00)">

	<?php
		$uname = $_SESSION['username'];
		//echo "<h1 style='color:blue;'>$username</h1>";
		$servername= "localhost";
	        $username="unstopq7_admin";
      		$password="db@dmin23";
	    	$db="unstopq7_gameRental";

	        $conn = new mysqli($servername, $username, $password, $db);

	        if($conn->connect_error)
      		{
        		die("Connection failed: ". $conn->connect_error);
	        }
			else
			{
				echo "<h1 style='color:white'>Connection Successful</h1>";
			}
		$uname = stripping($_SESSION["username"]);
		$sql = "SELECT O.name, O.did, O.day_received, O.day_returned FROM Orders O WHERE O.username = '$uname';"; //UNION SELECT `P.name`, `P.sid`, `P.day_recieved`, `P.day_returned` FROM `Pickup P` WHERE `P.username` = '$uname' ORDER BY `day_received` DESC LIMIT 5;";
		$result = $conn->query($sql);
	?>

    <div class="container-fluid">
      <div class="row">
        <div class="span12" style="position: relative; background-color:maroon; width: 100%; height: 50px; display: table;">
          <h1 style="text-align:center; color: white;">Flash Game Rental</h1>
        </div>
      </div>
      <div class="row">
      	<div class="span12">
        	<h5 onClick="backHome();" style="color:white;">Home</h5>
        </div>
      </div>
		<div class="row" style="margin-top:40px; margin-right:10px;">
			<div class="col-sm-4">
				<?php echo "<h1 class='info'>Welcome Back $uname</h1>";?>
            </div>
        </div>
        <div class="row">
			<div class="col-sm-12">
				<h2 class="info" style="height:50px; text-align:center; margin-left:-12px">Information Area</h2>
			</div>
		</div>
        <div class="row">
        <table>
        	<tr>
            	<td>Name</td>
                <td>did</td>
                <td>day_received</td>
                <td>day_returned</td>
            </tr>
        <?php
		//$result = mysql_query('$sql');		
		//echo "$sql";
		echo "$sql";
		//if($result->num_rows > 0)
		//{
		while($row1 = $result->fetch_assoc())
		{
				echo "<tr>";
				echo "<td>".$row1["name"]."</td>";
				echo "<td>".$row1["did"]."</td>";
				echo "<td>".$row1["day_received"]."</td>";
				echo "<td>".$row1["day_returned"]."</td>";
				echo "</tr>";
		}
	//	}
		/*else
		{
			echo "<h1 style ='color:white;'>0 results</h1>";
		}*/

      function stripping($data)
      {
        $data= trim($data);
        $data= stripslashes($data);
        $data = htmlspecialchars($data);
        return ($data);
      }

		?>
        </table>
        </div>
    </div>


    <!--                  php section here                    --->


  </body>
</html>
