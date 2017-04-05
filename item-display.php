<?php
require_once 'start.php'; //TODO restrict functionality if user is not logged in
?>
<!DOCTYPE html>
<html >
<head>
    <title>Item Display Page</title>
</head>
<body>
    <table>
        <tr>
            <th>Item Name</th>
            <th>Category</th>
            <th>Time Found</th>
            <th>Posted by User</th>
            <th>Place Found</th>
            <th>Colour</th>
            <th>Photo</th>
            <th>Description</th>
            <?php
                if(isLoggedIn()) {
                    echo "<th>Actions</th>";
                }
            ?>
        </tr>
<?php
    //TODO - Display items, let user filter items
    //by default display all
    // allow user to filter through
    require_once ('Database.php');
    require_once ('DatabaseAPI.php');
    $dbAPI = new DatabaseAPI();

    //for loop through for loop, and display all elements
    $items = $dbAPI->getItems();

    foreach ($items as $item){
        $itemName = $item['ItemName'];
        $category = $item['Category'];
        $foundTime = $item['FoundTime'];
        $userID = $item['UserID'];
        $foundPlace = $item['FoundPlace'];
        $colour = $item['Colour'];
        $photo = $item['Photo'];
        $desc = $item['Description'];

        echo "<tr>";
        echo "<td>$itemName</td>";
        echo "<td>$category</td>";
        echo "<td>$foundTime</td>";
        echo "<td>$userID</td>";
        echo "<td>$foundPlace</td>";
        echo "<td>$colour</td>";
        echo "<td><img src='$photo'/></td>";
        echo "<td>$desc</td>";
        if (isLoggedIn()) {

        }
        echo "</tr>";
}
?>
    </table>
    <p ><a href = "user-home.php" > Go back to home page</a ></p >
</body>
</html>