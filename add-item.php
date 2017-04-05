<!DOCTYPE html>
<html>
<head>
    <title>Add an item</title>
</head>
<?php
require_once 'start.php';
require_once ('Database.php');
require_once ('DatabaseAPI.php');
$dbAPI = new DatabaseAPI();
if(isLoggedIn()) {
?>
<body>
<form method="post" action="add-item.php" enctype="multipart/form-data">
    Name: <input type="text" name="itemname" /><br /><br />
    Category: <select name="category">
        <option value="Pet" selected="selected" >Pet</option>
        <option value="Phone" >Phone</option>
        <option value="Jewellery" >Jewellery</option>
    </select><br /><br />
    Place found: <input type="text" name="place" /><br /><br />
    Colour: <input type="text" name="colour" /><br /><br />
    Photo: <input name="photo" type="file"><br /><br />
    Description: <input type="text" name="desc" /><br /><br />
    <input type="submit" name="submit" value="Add" />
    <input type="hidden" name="submitted" value="true"/>
</form>
<p ><a href = "user-home.php" > Go back to home page</a ></p >
<?php
if (isset($_POST["submitted"])){

    //all the information is in the $_POST array.
    //step one, get the information

    $errors = array();

    //if the itemname isn't empty (so there is a value for it)
    if (!empty($_POST['itemname'])){
        $itemname = $_POST['itemname'];
    } else {
        $errors[] = "Name was not entered.";
    }

    $category = $_POST['category'];

    //if the place found isn't empty (so there is a value for it)
    if (!empty($_POST['place'])){
        $place = $_POST['place'];
    } else {
        $errors[] = "Place found was not entered.";
    }

    //if the colour isn't empty (so there is a value for it)
    if (!empty($_POST['colour'])){
        $colour = $_POST['colour'];
    } else {
        $errors[] = "Colour was not entered.";
    }

    //if the photo isn't empty (so there is a value for it)
    if (isset($_FILES['photo'])){
//        $photo = $_FILES['photo'];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        //Check file type
        if($imageFileType == "jpg" || $imageFileType == "jpeg" || $imageFileType == "png"){
            if ($_FILES["photo"]["size"] < 10000000) {

                $fileDest =  $target_dir . md5(microtime());
                $filepath = $fileDest . "." . $imageFileType;

                if (move_uploaded_file($_FILES["photo"]["tmp_name"], $filepath)) {
                    echo "The file ". $filepath . " has been uploaded.";

                } else {
                    $errors[] = "Could not upload photo";
                }
            }else{
                $errors[] = "Photo size is too large";
            }
        }else{
            $errors[] = "Photo file type is wrong";
        }
    } else {
        $errors[] = "Photo was not entered.";
    }

    //if the description isn't empty (so there is a value for it)
    if (!empty($_POST['desc'])){
        $desc = $_POST['desc'];
    } else {
        $errors[] = "Description was not entered.";
    }

    //if the errors array is empty then we can login
    if (empty($errors)){
        //form fill successful
        $userID = getSessionUserID();
        $dbAPI->addItem($itemname,$category,$userID,$place,$colour,$filepath,$desc);
        echo "<p>Item added successfully!</p><br>";
        echo "<p>You can add another item.</p>";
    } else { //errors is not empty, so we print out the error messages
        echo "<h1> Errors with adding item: </h1> \n <ul>";
        foreach ($errors as $e){
            echo "<li> $e </li>";
        }
        echo "</ul>";
    }

}

?>
</body>
</html>

    <?php
}else{
    echo "Error: You aren't logged in! Redirecting you...";
    header("Location: index.php");
}