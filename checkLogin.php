<?php
    
    session_start();
    // Check if the user is already logged in, if yes then redirect him to index page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        
    }
    else {
        header("location: login.php");
        exit;
    }
?>