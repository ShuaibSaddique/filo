<!DOCTYPE html>
<html >
<head>
<title>User Homepage | Aston Animal Sanctuary</title>
</head>
<?php
session_start();
if (!isset($_SESSION["username"])) {	
	echo "<em>You are not signed in! Redirecting...</em>"; 	
	header('Refresh: 2; http://www.khana46.eas-cs2410-1516.aston.ac.uk/login.php') ;	
}
else {
	$username = $_SESSION["username"];
	$db = new PDO("mysql:dbname=khana46_db;host=localhost", "khana46", "halm11jura");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	?>
	<style>
	#logout{
		position: absolute;
		top:1%;
		right:1%;
	}
	</style>
	<div id="logout">
	Logged in as <strong><em> <?php echo $username ?> </em></strong>&nbsp; | &nbsp; <a href=http://www.khana46.eas-cs2410-1516.aston.ac.uk/logout.php ><strong>Logout</strong></a>
	</div>
	<body>
		 <h2><u>User Homepage</u></h2>
		 <h3><u>Your Animals:</u></h3>
		 
	<?php
	try {
		 $stmt = $db->prepare("SELECT animalID FROM owns WHERE userID = '" . $username . "'");
		 $stmt->execute();
		 $stmt->setFetchMode(PDO::FETCH_ASSOC);
		 $fetch = $stmt->fetchAll();	 
		 
		 if ($stmt->rowCount()==0) {
			 echo "<em>No animals to show</em>";
		 }
		 else {
			 echo "<table style='border: solid 1px black;'>";
			 echo "<tr><th>Name</th><th>Date of Birth</th><th>Description</th><th>Picture</th></tr>";
			 foreach($fetch as $keys=>$values) {
				 foreach ($values as $value){
					 $stmt2 = $db->prepare("SELECT name, dateofbirth, description, photo FROM animal WHERE animalID = '" . $value . "'");
					 $stmt2->execute();
					 $stmt2->setFetchMode(PDO::FETCH_ASSOC);
					 $fetch2 = $stmt2->fetchAll();
					 
					 foreach ($fetch2 as $keys2=>$values2) {
						 $i = 0;
						 foreach ($values2 as $value2) {
							 if (substr( $value2, 0, 4 ) === "http") {
								 echo "<td style='width: 150px; border: 1px solid black;'><img src = " . $value2 . " style=height:100px></td>";
							 }
							 elseif ($value2=="") {
								 echo "<td style='width: 150px; border: 1px solid black;'><em>Unavailable</em></td>";
							 }
							 else {
								 echo "<td style='width: 150px; border: 1px solid black;'>$value2</td>";
							 }					 
							 $i++;
							 if ($i%4==0) {
								 echo "</tr><tr>";
								 $i=0;
							 }
						 }		 
					 }
				 }
			 }
		 }
	}
	catch(PDOException $e) {
		 echo "Error: " . $e->getMessage();
	}
	?>
	</tr></table>		

	<h3><u>Your Pending Adoption Requests:</u></h3>
	
	<?php
	try {
		 $stmt = $db->prepare("SELECT animalID FROM adoptionrequest WHERE userID = '" . $username . "' AND approved IS NULL");
		 $stmt->execute();
		 $stmt->setFetchMode(PDO::FETCH_ASSOC);
		 $fetch = $stmt->fetchAll();	 
		 
		 if ($stmt->rowCount()==0) {
			 echo "<em>You have no pending adoption requests.</em>";
		 }
		 else {
			 echo "<table style='border: solid 1px black;'>";
			 echo "<tr><th>Name</th><th>Date of Birth</th><th>Description</th><th>Picture</th></tr>";
			 foreach($fetch as $keys=>$values) {
				 foreach ($values as $value){
					 $stmt2 = $db->prepare("SELECT name, dateofbirth, description, photo FROM animal WHERE animalID = '" . $value . "'");
					 $stmt2->execute();
					 $stmt2->setFetchMode(PDO::FETCH_ASSOC);
					 $fetch2 = $stmt2->fetchAll();
					 
					 foreach ($fetch2 as $keys2=>$values2) {
						 $i = 0;
						 foreach ($values2 as $value2) {
							 if (substr( $value2, 0, 4 ) === "http") {
								 echo "<td style='width: 150px; border: 1px solid black;'><img src = " . $value2 . " style=height:100px></td>";
							 }
							 elseif ($value2=="") {
								 echo "<td style='width: 150px; border: 1px solid black;'><em>Unavailable</em></td>";
							 }
							 else {
								 echo "<td style='width: 150px; border: 1px solid black;'>$value2</td>";
							 }					 
							 $i++;
							 if ($i%4==0) {
								 echo "</tr><tr>";
								 $i=0;
							 }
						 }		 
					 }
				 }
			 }
		 }
	}
	catch(PDOException $e) {
		 echo "Error: " . $e->getMessage();
	}
	?>
	</tr></table>	
	
	<h3><u>Animals Available For Adoption:</u></h3>
	
	<?php
	try {
		 $stmt = $db->prepare("SELECT name, dateofbirth, description, photo FROM animal WHERE available = 1");
		 $stmt->execute();
		 $stmt->setFetchMode(PDO::FETCH_ASSOC);
		 $fetch = $stmt->fetchAll(); 
		 
		 if ($stmt->rowCount()==0) {
			 echo "<em>Sorry, there are currently no animals available to adopt.</em>";
		 }
		 else {
			 echo "<table style='border: solid 1px black;'>";
			 echo "<tr><th>Name</th><th>Date of Birth</th><th>Description</th><th>Picture</th></tr>";
				 foreach ($fetch as $keys=>$values) {
					 $i = 0;
					 foreach ($values as $value) {					 
						 if (substr( $value, 0, 4 ) === "http") {
							 echo "<td style='width: 150px; border: 1px solid black;'><img src = " . $value . " style=height:100px></td>";		 
						 }
						 elseif ($value=="") {
							 echo "<td style='width: 150px; border: 1px solid black;'><em>Unavailable</em></td>";
						 }
						 else {
							 echo "<td style='width: 150px; border: 1px solid black;'>$value</td>";
						 }					 
						 $i++;
						 
						 if ($i%4==0) {
							 echo "</tr><tr>";
							 $i=0;
						 }
					 }
				 }
				 ?>
				 </tr></table>	
				 <br>
				 <form method = "post" action="adoptionrequest.php">
				 <em>Select animal you would like to adopt:</em> &nbsp;&nbsp;&nbsp;&nbsp;<select name="adoption">			 
				 <?php
				 $stmt2 = $db->prepare("SELECT name FROM animal WHERE available = 1");
				 $stmt2->execute();
				 $stmt2->setFetchMode(PDO::FETCH_ASSOC);
				 $fetch2 = $stmt2->fetchAll();
				 $n=0;
				 foreach ($fetch2 as $keys=>$values) {
					 foreach ($values as $value) {						 
						 echo "<option value=$n> " . $value . " </option>";
						 $n++;
					 }
				 }
				 ?>
				 </select>
				 &nbsp;&nbsp; <input type="submit" name="confirm" value="Confirm Adoption Request" />
				 </form>
				 <?php
		 }
	}
	catch(PDOException $e) {
		 echo "Error: " . $e->getMessage();
	}
	?>

	<h3><u>View Your Adoption Request History:</u></h3>
	
	<h4><u>Approved:</u></h4>
	
	<?php
	try {
		 $stmt = $db->prepare("SELECT animalID FROM adoptionrequest WHERE userID = '" . $username . "' AND approved = '1'");
		 $stmt->execute();
		 $stmt->setFetchMode(PDO::FETCH_ASSOC);
		 $fetch = $stmt->fetchAll();	 
		 
		 if ($stmt->rowCount()==0) {
			 echo "<em>No history found.</em>";
		 }
		 else {
			 echo "<table style='border: solid 1px black;'>";
			 echo "<tr><th>Name</th><th>Date of Birth</th><th>Description</th><th>Picture</th></tr>";
			 foreach($fetch as $keys=>$values) {
				 foreach ($values as $value){
					 $stmt2 = $db->prepare("SELECT name, dateofbirth, description, photo FROM animal WHERE animalID = '" . $value . "'");
					 $stmt2->execute();
					 $stmt2->setFetchMode(PDO::FETCH_ASSOC);
					 $fetch2 = $stmt2->fetchAll();
					 
					 foreach ($fetch2 as $keys2=>$values2) {
						 $i = 0;
						 foreach ($values2 as $value2) {
							 if (substr( $value2, 0, 4 ) === "http") {
								 echo "<td style='width: 150px; border: 1px solid black;'><img src = " . $value2 . " style=height:100px></td>";
							 }
							 elseif ($value2=="") {
								 echo "<td style='width: 150px; border: 1px solid black;'><em>Unavailable</em></td>";
							 }
							 else {
								 echo "<td style='width: 150px; border: 1px solid black;'>$value2</td>";
							 }					 
							 $i++;
							 if ($i%4==0) {
								 echo "</tr><tr>";
								 $i=0;
							 }
						 }		 
					 }
				 }
			 }
		 }
	}
	catch(PDOException $e) {
		 echo "Error: " . $e->getMessage();
	}
	?>
	</tr></table>	
	
	<h4><u>Declined:</u></h4>
	
	<?php
	try {
		 $stmt = $db->prepare("SELECT animalID FROM adoptionrequest WHERE userID = '" . $username . "' AND approved = '0'");
		 $stmt->execute();
		 $stmt->setFetchMode(PDO::FETCH_ASSOC);
		 $fetch = $stmt->fetchAll();	 
		 
		 if ($stmt->rowCount()==0) {
			 echo "<em>No history found.</em>";
		 }
		 else {
			 echo "<table style='border: solid 1px black;'>";
			 echo "<tr><th>Name</th><th>Date of Birth</th><th>Description</th><th>Picture</th></tr>";
			 foreach($fetch as $keys=>$values) {
				 foreach ($values as $value){
					 $stmt2 = $db->prepare("SELECT name, dateofbirth, description, photo FROM animal WHERE animalID = '" . $value . "'");
					 $stmt2->execute();
					 $stmt2->setFetchMode(PDO::FETCH_ASSOC);
					 $fetch2 = $stmt2->fetchAll();
					 
					 foreach ($fetch2 as $keys2=>$values2) {
						 $i = 0;
						 foreach ($values2 as $value2) {
							 if (substr( $value2, 0, 4 ) === "http") {
								 echo "<td style='width: 150px; border: 1px solid black;'><img src = " . $value2 . " style=height:100px></td>";
							 }
							 elseif ($value2=="") {
								 echo "<td style='width: 150px; border: 1px solid black;'><em>Unavailable</em></td>";
							 }
							 else {
								 echo "<td style='width: 150px; border: 1px solid black;'>$value2</td>";
							 }					 
							 $i++;
							 if ($i%4==0) {
								 echo "</tr><tr>";
								 $i=0;
							 }
						 }		 
					 }
				 }
			 }
		 }
	}
	catch(PDOException $e) {
		 echo "Error: " . $e->getMessage();
	}
	?>
	</tr></table>	

	</body>
	<?php
	}
	?>
</html>
