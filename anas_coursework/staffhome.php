<!DOCTYPE html>
<html >
<head>
<title>Staff Homepage | Aston Animal Sanctuary</title>
</head>
<?php
session_start();
if (!isset($_SESSION["username"])) {
	echo "<em>You are not signed in! Redirecting...</em>"; 	
	header('Refresh: 2; http://www.khana46.eas-cs2410-1516.aston.ac.uk/logout.php') ;	
}
else {
	if ($_SESSION["staff"] == 0) {
		echo "You do not have permission to access this page!";
		header('Refresh: 2; http://www.khana46.eas-cs2410-1516.aston.ac.uk/userhome.php') ;	
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
		 <h2><u>Staff Homepage</u></h2>
		 <h3><u>Animals Available:</u></h3>
		 
	<?php
	try {
		 $stmt = $db->prepare("SELECT name, dateofbirth, description, photo FROM animal WHERE available = '1'");
		 $stmt->execute();
		 $stmt->setFetchMode(PDO::FETCH_ASSOC);
		 $fetch = $stmt->fetchAll();
		 if ($stmt->rowCount()==0) {
			 echo "<em>No animals are available </em>";
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
		 }
	}
	catch(PDOException $e) {
		 echo "Error: " . $e->getMessage();
	}

	?>
	</tr></table>
	
	<!---------------
	#
	#	ADD Animal
	#
	----------------->
	
	<h3><u>Handle Adoption Requests:</u></h3>
	<?php
	try {
		 $stmt = $db->prepare("SELECT animalID FROM adoptionrequest WHERE approved IS NULL");
		 $stmt->execute();
		 $stmt->setFetchMode(PDO::FETCH_ASSOC);
		 $fetch = $stmt->fetchAll();	 
		 
		 if ($stmt->rowCount()==0) {
			 echo "<em>There are no pending adoption requests.</em>";
		 }
		 else {
			 echo "<table style='border: solid 1px black;'>";
			 echo "<tr><th>Name</th><th>Date of Birth</th><th>Description</th><th>Picture</th></tr>";
			 foreach($fetch as $keys=>$values) {
				 foreach ($values as $animalID){
					 $stmt2 = $db->prepare("SELECT name, dateofbirth, description, photo FROM animal WHERE animalID = '" . $animalID . "'");
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
			 
			 ?>
			 </tr></table>	
	
			 <form method = "post" action="handlerequest.php">
			 <em>Select request to handle:</em> &nbsp;&nbsp;&nbsp;&nbsp;<select name="handle">			 
			 <?php
			 $stmt = $db->prepare("SELECT animalID FROM adoptionrequest WHERE approved IS NULL");
			 $stmt->execute();
			 $stmt->setFetchMode(PDO::FETCH_ASSOC);
			 $fetch = $stmt->fetchAll();	 
			 foreach($fetch as $keys=>$values) {
				 foreach ($values as $animalID){}
				 $stmt2 = $db->prepare("SELECT name FROM animal WHERE animalID = '" . $animalID . "'");
				 $stmt2->execute();
				 $stmt2->setFetchMode(PDO::FETCH_ASSOC);
				 $fetch2 = $stmt2->fetchAll();
				 $n=0;
				 foreach ($fetch2 as $keys=>$values3) {
					 foreach ($values3 as $value) {						 
						 echo "<option value=$n> " . $value . " </option>";
						 $n++;
					 }			 
				 }
			 }
			 ?>
			 </select>
			 
			 <!--incomplete-->
			 
			 &nbsp;&nbsp; <input type="submit" name="confirm" value="Approve" />
			 &nbsp;&nbsp; <input type="submit" name="confirm" value="Deny" />
			 </form>
			 <?php
		 }
	}
	catch(PDOException $e) {
		 echo "Error: " . $e->getMessage();
	}
	?>
	
	
	<h3><u>Adoption Request History:</u></h3>
	
	<h4><u>Approved:</u></h4>
	
	<?php
	try {
		 $stmt = $db->prepare("SELECT animalID FROM adoptionrequest WHERE approved = '1'");
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
		 $stmt = $db->prepare("SELECT animalID FROM adoptionrequest WHERE approved = '0'");
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
	
	
<?php
	}
}
?>
</body>
</html>