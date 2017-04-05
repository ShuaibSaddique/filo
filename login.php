<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<?php
require_once 'start.php';
require_once ('Database.php');
require_once ('DatabaseAPI.php');
$dbAPI = new DatabaseAPI();
if(isLoggedIn()) {
    echo "Error: You are already logged in! Redirecting you...";
    if (isAdmin()) {
        header("Location: admin-home.php");
    } else {
        header("Location: user-home.php");
    }
} else {
?>
<body>
<form method="post" action="login.php">
    Username: <input type="text" name="username" /><br /><br />
    Password: <input type="text" name="password" /><br /><br />
    <input type="submit" name="login" value="Login" />
    <input type="hidden" name="submitted" value="true"/>
</form>
Don't have an account? <a href="register.php"><em>Click here to register.</em></a><br>
<p ><a href = "index.php" > Go back to home page</a ></p >
<?php
if (isset($_POST["submitted"])){

    //all the information is in the $_POST array.
    //step one, get the information

    $errors = array();

    //if the username isn't empty (so there is a value for it)
    if (!empty($_POST['username'])){
        $username = $_POST['username'];
    } else {
        $errors[] = "Username was not entered.";
    }

    //if the password isn't empty (so there is a value for it)
    if (!empty($_POST['password'])){
        $password = md5($_POST['password']);
        echo "$password";
    } else {
        $errors[] = "Password was not entered.";
    }

    //if the username is incorrect
    if ($dbAPI->checkUsernameExists($_POST['username']) == false){
        $errors[] = "Username entered is incorrect. Please try again.";
    }

    //if the password is incorrect
    if ($dbAPI->verifyPassword($password, $_POST['username']) == false){
        $errors[] = "Password entered is incorrect. Please try again.";
    }

    //if the errors array is empty then we can login
    if (empty($errors)){
        //login successful
        $userID = $dbAPI->getUserUserID($_POST['username']);
        $userID = $userID['UserID'];

        $_SESSION['UserID'] = $userID;

        if ($dbAPI->getUserAdminStatus($userID) == 1) {
            //user is admin - take to admin page
            header("Location: admin-home.php");
        } else {
            //user is registered user - take to user page
            header("Location: user-home.php");
        }
    } else { //errors is not empty, so we print out the error messages
        echo "<h1> Errors with login: </h1> \n <ul>";
        foreach ($errors as $e){
            echo "<li> $e </li>";
        }
        echo "</ul>";
    }

} else {

    }
}
?>
</body>
</html>