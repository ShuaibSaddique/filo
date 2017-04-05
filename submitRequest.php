<?php
require_once 'start.php';
require_once ('Database.php');
require_once ('DatabaseAPI.php');
$dbAPI = new DatabaseAPI();

if(isset($_POST['id'])){

    $dbAPI->addRequest(getSessionUserID(), $_POST['id'],"Pending", "User has requested this item");


}