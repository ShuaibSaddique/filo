<?php
session_start();
session_unset();
session_destroy();
header('Refresh: 2; http://www.khana46.eas-cs2410-1516.aston.ac.uk/login.php');
?>