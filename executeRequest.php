<?php
    var_dump($_POST);
    require_once 'start.php';
    require_once ('Database.php');
    require_once ('DatabaseAPI.php');
    $dbAPI = new DatabaseAPI();

    if(isset($_POST['request_id']) && isset($_POST['value'])) {
        $dbAPI->setRequestStatus($_POST['value'],$_POST['request_id']);
    }
?>