<?php 
    session_start();
    $_SESSION['id'] = "";
    header("Location: ../self_info/index.php"); 
    exit;

 ?>