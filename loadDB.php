<?php
require_once ('Database.php');
require_once ('DatabaseAPI.php');

    $dbAPI = new DatabaseAPI();
    $result = $dbAPI->getUserUserID("testuser");
    echo $result['UserID'];

//    $db = Database::getDB();
//
//    $query = "SELECT * FROM user";
//    $sql = $db->prepare($query);
//    $sql->execute();
//
//    $result = $sql->fetchAll();
//    var_dump($result);
// TODO - make sure to add constraints to table
// TODO - integrate db into server
?>