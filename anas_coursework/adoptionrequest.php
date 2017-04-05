<!DOCTYPE html>
<html>
<head>
<title>Request Successful | Aston Animal Sanctuary</title>
</head>
<?php
session_start();
if (!isset($_SESSION["username"])) {
	echo "<em>You are not signed in! Redirecting...2</em>"; 	
	header('Refresh: 2; http://www.khana46.eas-cs2410-1516.aston.ac.uk/login.php') ;	
}
else {
	$username = $_SESSION["username"];
	$adoption = $_POST['adoption'];
	$db = new PDO("mysql:dbname=khana46_db;host=localhost", "khana46", "halm11jura");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "<body>";
	try {
		 $stmt = $db->prepare("SELECT name FROM animal WHERE available = 1");
		 $stmt->setFetchMode(PDO::FETCH_ASSOC);
		 $stmt->execute();
		 foreach($stmt as $values) {
			 foreach ($values as $value) {
				 $animals[] = $value;
			 }
		 }
		 $stmt2= $db->query("SELECT animalID FROM animal WHERE name = '" . $animals[$adoption] . "'");
		 $stmt2->setFetchMode(PDO::FETCH_ASSOC);
		 foreach ($stmt2 as $values2) {
			 foreach ($values2 as $value2){
			 }
		 }
		 $query2 = "SELECT * FROM adoptionrequest WHERE userID = '" . $username . "' AND animalID = '" . $value2 . "'";
		 $rows = $db->query($query2);
		 $rowcount = $rows->rowCount();
		 $insert = "INSERT INTO adoptionrequest (userID, animalID) VALUES ('" . $username . "', '" . $value2 . "')";
		 $stmt3 = $db->prepare($insert);
		 $stmt3->execute();
		 $update = "UPDATE animal SET available = '0' WHERE animalID = '" . $value2 . "'";
		 $stmt4 = $db->prepare($update);
		 $stmt4->execute();
		 /*$insert2 = "INSERT INTO owns (userID, animalID) VALUES ('khana46', '" . $value2 . "')";
		 $stmt5 = $db->prepare($insert2);
		 $stmt5->execute();*/
		 echo "<em>Your adoption request was successful! Redirecting...</em>";
		 header('Refresh: 3; http://www.khana46.eas-cs2410-1516.aston.ac.uk/userhome.php') ;	
	}
	catch(PDOException $e) {
		 echo "Error: " . $e->getMessage();
	}
}
?>
</body>
</html>
