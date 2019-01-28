<?php
//setcookie("user_id","01");
session_start();

if(!$connection = mysqli_connect('localhost', 'root', '', 'su_db')){
    
    printf("Connessione fallita!: %s\n", mysqli_connect_error());
    exit();
}

?>