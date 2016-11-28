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
<link rel="stylesheet" href="http://unstoppabledesignstudio.com/school.css">
<link href="https://fonts.googleapis.com/css?family=Bungee" rel="stylesheet">
    <script src="https://unpkg.com/react@latest/dist/react.js"></script>
    <script src="https://unpkg.com/react-dom@latest/dist/react-dom.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>

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
		$uname = stripping($_SESSION["username"]);
		$sql = "SELECT O.name, O.did, O.day_received, O.day_returned FROM Orders O WHERE O.username = '$uname' UNION SELECT P.name, P.sid, P.day_recieved, P.day_returned FROM Pickup P WHERE P.username = '$uname' ORDER BY day_received DESC LIMIT 5;";
		$result = $conn->query($sql);
	?>

    <div class="container-fluid">
      <div class="row">
        <div class="span12" style="position: relative; background-color:maroon; width: 100%; height: 50px; display: table;">
          <h1 style="text-align:center; color: white;">Flash Game Rental</h1>
        </div>
      </div>
      <div class="row">
      <div class="col-sm-4">
        	<h6>.</h6>
        </div>
      	<div class="col-sm-4">
        	<button type='button' id='my-account-button' class="btn btn-default" onClick="backHome()" style="margin-left: 200px;">Home</button>
        </div>
        <div class="col-sm-4">
        	<h6>.</h6>
        </div>
      </div>
		<div class="row" style="margin-top:40px; margin-right:15px;">
			<div class="col-sm-12">
				<?php echo "<h1 class='info2'>Welcome Back $uname</h1>";?>
            </div>
        </div>
        <div class="row">
			<div class="col-sm-12">
				<h2 class="info" style="height:50px; text-align:center; margin-left:-12px">Information Area</h2>
			</div>
		</div>
        <div class="row">
			<div class="col-sm-12">
				<h3 class="info" style="height:30px; text-align:left; margin-left:-12px; font-family: Bungee">5 Recent Orders/Pickups</h3>
			</div>
		</div>
        <div class="row">
        <table class="main">
        	<tr class = "tr-main">
            	<th class = "th-main">Name</td>
                <th class = "th-main">did</td>
                <th class = "th-main">day_received</td>
                <th class = "th-main">day_returned</td>
            </tr>
        <?php
		//$result = mysql_query('$sql');		
		//echo "$sql";
		//echo "$sql";
		//if($result->num_rows > 0)
		//{
		while($row1 = $result->fetch_assoc())
		{
				echo "<tr class = 'tr-main'>";
				echo "<td class = 'td-main'>".$row1["name"]."</td>";
				echo "<td class = 'td-main'>".$row1["did"]."</td>";
				echo "<td class = 'td-main'>".$row1["day_received"]."</td>";
				echo "<td class = 'td-main'>".$row1["day_returned"]."</td>";
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
        <div class="row">
			<div class="col-sm-12">
				<h3 class="info" style="height:30px; text-align:left; margin-left:-12px; font-family: Bungee">Current Checked Out Games</h3>
			</div>
		</div>
        <div class="row">
        <table class="main">
        	<tr class = "tr-main">
            	<th class = "th-main">Name</td>
                <th class = "th-main">day_received</td>
                <th class = "th-main">Price</td>
            </tr>
        <?php
		//$result = mysql_query('$sql');		
		//echo "$sql";
		//echo "$sql";
		//if($result->num_rows > 0)
		//{
		$sql = "SELECT G.name, O.day_received, G.price FROM Orders O, Games G WHERE O.name = G.name AND O.username = '$uname' AND O.day_returned IS NULL UNION SELECT G.name, P.day_recieved, G.price FROM Pickup P, Games G WHERE P.name = G.name AND P.username = '$uname' AND P.day_returned IS NULL";
	$result = $conn->query($sql);
	$calculatePrice = 0.00;
	if($result->num_rows > 0)
	{
		while($row1 = $result->fetch_assoc())
		{
				echo "<tr class = 'tr-main'>";
				echo "<td class = 'td-main'>".$row1["name"]."</td>";
				//echo "<td class = 'td-main'>".$row1["did"]."</td>";
				echo "<td class = 'td-main'>".$row1["day_received"]."</td>";
				echo "<td class = 'td-main'>".$row1["price"]."</td>";
				echo "</tr>";
				$calculatePrice += $row1["price"];
		}
	}
	else
	{
		echo "</table>";
		echo "<h1 class='info' style='height:30px; text-align:left; margin-left:-12px'>0 Results<h1>";
	}
	//	}
		/*else
		{
			echo "<h1 style ='color:white;'>0 results</h1>";
		}*/
//		echo $calculatePrice;
		?>
        </table>
        </div>
        <div class="row">
			<div class="col-sm-12">
				<?php echo "<h3 class='info' style='height:30px; text-align:left; margin-left:-12px'>Total Price of Games: ".$calculatePrice."</h3>";?>
			</div>
		</div>
        <div class="row">
			<div class="col-sm-12">
				<h3 class="info" style="height:30px; text-align:left; margin-left:-12px; font-family: Bungee">TOP 5 POPULAR GAMES</h3>
			</div>
		</div>
        <div class="row">
        <table class="main">
        	<tr class = "tr-main">
            	<th class = "th-main">Name</td>
                <th class = "th-main">Number of Pickups</td>
            </tr>
        <?php
		//$result = mysql_query('$sql');		
		//echo "$sql";
		//echo "$sql";
		//if($result->num_rows > 0)
		//{
		$sql = "SELECT P.name, (P.num_pickups + O.num_orders) AS num_rentals FROM popular_pickup P, popular_orders O WHERE P.name = O.name ORDER BY num_rentals DESC LIMIT 5";
	$result = $conn->query($sql);
	//$calculatePrice = 0.00;
	if($result->num_rows > 0)
	{
		while($row1 = $result->fetch_assoc())
		{
				echo "<tr class = 'tr-main'>";
				echo "<td class = 'td-main'>".$row1["name"]."</td>";
				//echo "<td class = 'td-main'>".$row1["did"]."</td>";
				//echo "<td class = 'td-main'>".$row1["day_received"]."</td>";
				echo "<td class = 'td-main'>".$row1["num_rentals"]."</td>";
				echo "</tr>";
				//$calculatePrice += $row1["price"];
		}
	}
	else
	{
		echo "</table>";
		echo "<h1 class='info' style='height:30px; text-align:left; margin-left:-12px'>0 Results<h1>";
	}
	//	}
		/*else
		{
			echo "<h1 style ='color:white;'>0 results</h1>";
		}*/
//		echo $calculatePrice;
		?>
        </table>
        </div>
    </div>


    <!--                  php section here                    --->


  </body>
</html>
