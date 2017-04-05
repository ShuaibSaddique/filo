<!DOCTYPE html>
<html>
<head>
    <title>Register Page</title>
</head>
<body>
<?php
require_once 'start.php';
require_once ('Database.php');
require_once ('DatabaseAPI.php');
$dbAPI = new DatabaseAPI();
if(!isLoggedIn()) {
    ?>
    <form method="post" action="register.php">
        Username: <input type="text" name="username"/><br/><br/>
        Password: <input type="text" name="password"/><br/><br/>
        Confirm Password: <input type="text" name="confirmPassword"/><br/><br/>
        Firstname: <input type="text" name="firstname"/><br/><br/>
        Surname: <input type="text" name="surname"/><br/><br/>
        Gender: <br>
        <div>
            <input type="radio" value="male" name="gender" checked/>Male
            <input type="radio" value="female" name="gender"/>Female
            <input type="radio" value="other" name="gender"/>Other <br/><br/>
        </div>
        Postcode: <input type="text" name="postcode"/><br/><br/>
        Telephone Number: <input type="text" name="telephoneno"/><br/><br/>
        <input type="submit" name="register" value="Register"/>
        <input type="hidden" name="submitted" value="true"/>
    </form>
    <p><a href="index.php"> Go back to home page</a></p>
    <?php
    if (isset($_POST["submitted"])) {

        //all the information is in the $_POST array.
        //step one, get the information

        $errors = array();

        //if the username isn't empty (so there is a value for it)
        if (!empty($_POST['username'])) {
            $username = $_POST['username'];
        } else {
            $errors[] = "Username was not entered.";
        }

        //if the password isn't empty (so there is a value for it)
        if (!empty($_POST['password'])) {
            $password = $_POST['password'];
        } else {
            $errors[] = "Password was not entered.";
        }

        //check if password confirmation is right
        if (!($_POST['password'] == $_POST['confirmPassword'])) {
            $errors[] = "Passwords do not match.";
        }

        //if the username already exists
        if ($dbAPI->checkUsernameExists($_POST['username']) == true) {
            $errors[] = "Username already exists.";
        }

        //if the firstname isn't empty (so there is a value for it)
        if (!empty($_POST['firstname'])) {
            $firstname = $_POST['firstname'];
        } else {
            $errors[] = "Firstname was not entered.";
        }

        //if the surname isn't empty (so there is a value for it)
        if (!empty($_POST['surname'])) {
            $surname = $_POST['surname'];
        } else {
            $errors[] = "Surname was not entered.";
        }

        $gender = $_POST['gender'];

        //if the postcode isn't empty (so there is a value for it)
        if (!empty($_POST['postcode'])) {
            if (!preg_match("/^[a-zA-Z0-9]{6}$/i", $_POST['postcode'])) {
                $errors[] = "Your postcode must be 6 characters long containing only letters and numbers.";
            } else {
                $postcode = $_POST['postcode'];
            }
        } else {
            $errors[] = "Postcode was not entered.";
        }

        //if the telephoneno isn't empty (so there is a value for it)
        if (!empty($_POST['telephoneno'])) {
            if (!preg_match("/^[0-9]{11}$/i", $_POST['telephoneno'])) {
                $errors[] = "Your telephone number must be 11 characters long containing numbers.";
            } else {
                $telephoneno = $_POST['telephoneno'];
            }
        } else {
            $errors[] = "Telephone number was not entered.";
        }

        //if the errors array is empty then we can login
        if (empty($errors)) {
            //step two, process
            //registration successful
            $dbAPI->addUser(0, $username, $password, $firstname, $surname, $gender, $postcode, $telephoneno);

            $userID = $dbAPI->getUserUserID($_POST['username']);
            $userID = $userID['UserID'];
            $_SESSION['UserID'] = $userID;
            header("Location: login.php");
        } else { //errors is not empty, so we print out the error messages
            echo "<h1> Errors with registration: </h1> \n <ul>";
            foreach ($errors as $e) {
                echo "<li> $e </li>";
            }
            echo "</ul>";
        }

    }
}else {
    echo "Error: You are already logged in! Redirecting you...";
    if (isAdmin()) {
        header("Location: admin-home.php");
    } else {
        header("Location: user-home.php");
    }
}
?>
</body>
</html>