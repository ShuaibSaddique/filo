<!DOCTYPE html>
<html>
<head>
<title>Register | Aston Animal Sanctuary</title>
</head>

<body>
<?php
	$errors = "<ul><strong>Error(s):</strong><br><em>";
	$e = false;
	if (isset($_POST['submitted'])) {
		if (!empty ($_POST['username'])) {
			$username = $_POST['username'];	
			if (!preg_match("/^[a-zA-Z0-9-]{4,16}$/i",$username)) {
				$errors = $errors . "<li>Your username must be 4 - 16 characters long containing only letters, numbers and hyphens.</li>"; 
				$e = true;
			}		
		}	
		else	{
			$errors = $errors . "<li>You must input a valid username! </li>";
			$e = true;
		}	
		if (!empty ($_POST['password'])) {
			$password = $_POST['password'];
			$hash = md5($password);
			if (!preg_match("/^[a-zA-Z0-9]{4,16}$/i",$password)) {
				$errors = $errors . "<li>Your password must be 4 - 16 characters long containing only letters and numbers.</li>"; 
				$e = true;
			}
			else {			
				if (!empty ($_POST['cpassword'])) {
				$cpassword = $_POST['cpassword'];	
				$chash = md5($cpassword);
				if ($password != $cpassword) {
					$errors = $errors . "<li>Your passwords do not match! </li>";
					$e = true;
				}				
			}
				else {
					$errors = $errors . "<li>You must confirm your password!</li>";
					$e = true;
				}
		}
	}
		else{
			$errors = $errors . "<li>You must input a valid password!</li>";
			$e = true;
		}	
		
				
		
		if ($e == false) {
			try {
				$db = new PDO("mysql:dbname=khana46_db;host=localhost", "khana46", "halm11jura");
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
				$query = "SELECT * FROM user WHERE userID = '" . $username . "'";
				$un = $db->query($query);
				$unfound = $un->rowCount();
				if ($unfound > 0) {
					$errors = $errors . "<li>Username already in use, please enter a different username.</li>";
					$e = true;
				}
				else {
					$exec = "INSERT INTO user(userID, staff, password) VALUES ('" . $username . "',0,'" . $hash . "')";
					$db->exec($exec);
					echo "Congratulations <em>" . $username . "</em>, your registration was successful. Please wait a moment to be redirected..."; 	
					header('Refresh: 3; http://www.khana46.eas-cs2410-1516.aston.ac.uk/login.php') ;	
				}						
			} 
			catch (PDOException $ex){
				//this catches the exception when it is thrown
				?>
				<h2><u>Register</u></h2>
				<form method = "post" action="register.php">
					<strong>Username:</strong> <input type="text" name="username" /><br />
					<strong>Password:</strong> <input type="password" name="password" /><br />
					<strong>Confirm password:</strong> <input type="password" name="cpassword" /><br /><br />	
					<input type="submit" name="register" value="Register" />	
					<input type="hidden" name="submitted" value="TRUE" />
					<input type="button" value="Back" onclick="window.location.href='../login.php'"/>
				</form>
				<?php
				echo "<strong>Sorry, a database error occurred. Please try again.<br> </strong>";
				echo "<strong>Error details: </strong><em>". $ex->getMessage()."</em>";
			}
		}			
		
		if ($e == true) {		
		?>
		<h2><u>Register</u></h2>
		<form method = "post" action="register.php">
			<strong>Username:</strong> <input type="text" name="username" /><br />
			<strong>Password:</strong> <input type="password" name="password" /><br />
			<strong>Confirm password:</strong> <input type="password" name="cpassword" /><br /><br />	
			<input type="submit" name="register" value="Register" />	
			<input type="hidden" name="submitted" value="TRUE" />
			<input type="button" value="Back" onclick="window.location.href='../login.php'"/>
		</form>
		<?php
		echo $errors . "</ul></em>";
		}	
		
						
	}
	else {
		?>
		<h2><u>Register</u></h2>
		<form method = "post" action="register.php">
			<strong>Username:</strong> <input type="text" name="username" /><br />
			<strong>Password:</strong> <input type="password" name="password" /><br />
			<strong>Confirm password:</strong> <input type="password" name="cpassword" /><br /><br />	
			<input type="submit" name="register" value="Register" />	
			<input type="hidden" name="submitted" value="TRUE" />
			<input type="button" value="Back" onclick="window.location.href='../login.php'"/>
		</form>
		<?php
	}

	
?>
</body>
</html>
