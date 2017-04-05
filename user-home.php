<?php
    require_once 'start.php';
    if(isLoggedIn() && !(isAdmin())) {
?>
<!DOCTYPE html>
<html >
<head>
    <title>Home Page</title>
</head>
<body>

<!--Need 2 texts to link to different pages-->
<p><a href="item-display.php">Item Search</a></p>
<p><a href="add-item.php">Add New Item</a></p>
<p><a href="logout.php">Logout</a></p>

</body>
</html>
<?php
}else if(isLoggedIn() && isAdmin()) {
    echo "Error: You aren't logged in as a user! Redirecting you...";
    header("Location: admin-home.php");
} else {
    echo "Error: You aren't logged! Redirecting you...";
    header("Location: login.php");
}