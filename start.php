<?php

ob_start();
session_start();

require_once ('Database.php');
require_once ('DatabaseAPI.php');


function getSessionUserID(){
    if(isset($_SESSION['UserID'])){
        return $_SESSION['UserID'];
    }else{
        return null;
    }
}

function isLoggedIn(){
    if(getSessionUserID() != null)
        return true;

    return false;
}

function isAdmin(){
    $userID = getSessionUserID();

    $dbAPI = new DatabaseAPI();
    $status = $dbAPI->getUserAdminStatus($userID);

    if( $status['IsAdmin'] == 1){
        return true;
    }else{
        return false;
    }
}

