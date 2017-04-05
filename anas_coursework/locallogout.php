<?php
session_start();
session_unset();
session_destroy();
header('Refresh: 2; http://localhost/projects/uni/coursework/login.php');
?>