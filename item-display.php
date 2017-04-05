<?php
require_once 'start.php'; //TODO restrict functionality if user is not logged in
?>
<!DOCTYPE html>
<html >
<head>
    <title>Item Display Page</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

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
            ?>
                <td><input type="button" value="Request" name="request-button" data-id="<?php echo $item['ItemID']; ?>"/></td>

            <script>

                $(function(){

                    $("input[name=request-button]").click(function () {

                        var id = $(this).data('id');

                        var data = {
                            id: id
                        };

                        $.ajax({

                            url: "submitRequest.php",
                            type: "post",
                            data: data,
                            success: function(response){
                                console.log(response);
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                console.log(errorThrown);
                            }

                        });

                    });

                });

            </script>
            <?php
        }
        echo "</tr>";
}
?>
    </table>
    <p ><a href = "user-home.php" > Go back to home page</a ></p >
</body>
</html>