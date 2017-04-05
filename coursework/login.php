<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Log in | Aston Animal Sanctuary</title>
</head>
<body>
<?php
	$errors = "<ul><strong>Error(s):</strong><br><em>";
	$e = false;
	if (isset($_POST['submitted'])) {
		if (!empty ($_POST['username'])) {
			$username = $_POST['username'];
		}	
		else	{
			$errors = $errors . "<li>Please enter a username.</li>";
			$e = true;
		}	
		if (!empty ($_POST['password'])) {
			$password = $_POST['password'];
			$hash = md5($password);
		}
		else{
			$errors = $errors . "<li>Please enter your password.</li>";
			$e = true;
		}
		$staff = $_POST['staff'];
		$_SESSION["staff"] = $staff;
		
		if ($e == false) {
			try {
				$db = new PDO("mysql:dbname=khana46_db;host=localhost", "khana46", "halm11jura");
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
				// use the form data to create a insert SQL and  add a student record  
				$query = "SELECT * FROM user WHERE staff = $staff AND userID = '" . $username . "' AND password = '" . $hash . "'";
				$users = $db->query($query);
				$usersfound = $users->rowCount();
				if (($usersfound > 0) && ($staff == 1)) {					
					header('Location: http://www.khana46.eas-cs2410-1516.aston.ac.uk/staffhome.php');
					$_SESSION["username"] = $username;
				}
				elseif (($usersfound > 0) && ($staff == 0)) {					
					header('Location: http://www.khana46.eas-cs2410-1516.aston.ac.uk/userhome.php');
					$_SESSION["username"] = $username;
				}
				else {
					$errors = $errors . "<li>User not found. Please try again or sign up using the link above.</li>";
					$e = true;
				}				
			} 
			catch (PDOException $ex){
				//this catches the exception when it is thrown
				?>
				<h2><u>Log in</u></h2>
				<form method = "post" action="login.php">
					<strong>Username:</strong> <input type="text" name="username" />
					<br>
					<strong>Password:</strong> <input type="password" name="password" />
					<br>
					<strong>Are you a member of staff? &nbsp;</strong>
						<input type="radio" value="1" name="staff" />Yes  &nbsp; &nbsp; 
						<input type="radio" value="0" name="staff" checked/>No
					<br><br>
					<input type="submit" name="register" value="Log in" />
					<input type="hidden" name="submitted" value="TRUE" />
					<br><br><br>
					Don't have an account? <a href="http://www.khana46.eas-cs2410-1516.aston.ac.uk/register.php"><em>Click here to register.</em></a>
				</form>
				<?php
				echo "<strong>Sorry, a database error occurred. Please try again.<br> </strong>";
				echo "<strong>Error details: </strong><em>". $ex->getMessage()."</em>";
			}
		}	
		
		if ($e == true) {		
		?>
		<h2><u>Log in</u></h2>
		<form method = "post" action="login.php">
			<strong>Username:</strong> <input type="text" name="username" />
			<br>
			<strong>Password:</strong> <input type="password" name="password" />
			<br>
			<strong>Are you a member of staff? &nbsp;</strong>
				<input type="radio" value="1" name="staff" />Yes  &nbsp; &nbsp; 
				<input type="radio" value="0" name="staff" checked/>No
			<br><br>
			<input type="submit" name="register" value="Log in" />
			<input type="hidden" name="submitted" value="TRUE" />
			<br><br><br>
			Don't have an account? <a href="http://www.khana46.eas-cs2410-1516.aston.ac.uk/register.php"><em>Click here to register.</em></a>
		</form>
		<?php
		echo $errors . "</ul></em>";
		}	
						
	}
	else {
		?>
		<h2><u>Log in</u></h2>
		<form method = "post" action="login.php">
			<strong>Username:</strong> <input type="text" name="username" />
			<br>
			<strong>Password:</strong> <input type="password" name="password" />
			<br>
			<strong>Are you a member of staff? &nbsp;</strong>
				<input type="radio" value="1" name="staff" />Yes  &nbsp; &nbsp; 
				<input type="radio" value="0" name="staff" checked/>No
			<br><br>
			<input type="submit" name="register" value="Log in" />
			<input type="hidden" name="submitted" value="TRUE" />
			<br><br><br>
			Don't have an account? <a href="http://www.khana46.eas-cs2410-1516.aston.ac.uk/register.php"><em>Click here to register.</em></a>
		</form>
		<?php
	}
	
?>
</body>
</html>
