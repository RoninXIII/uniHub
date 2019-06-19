<?php
require_once(realpath(dirname(__FILE__)) . '/Utente.php');
require_once('server.php');

if(isset($_POST['Refresh'])){

    $username = $_POST['Username'];
    $refresh = $_POST['Refresh'];
    if($refresh == 0) {$intervallo = null;}else{$intervallo = (int)$_POST['Intervallo'] * 1000;}
    if($query = mysqli_query($connection, "CALL su_update_user('$username','$refresh','$intervallo','')")){
        $_SESSION['utente'] -> setRefresh($refresh,$intervallo);
        echo json_encode("OK!");
    }else echo json_encode("Errore:".mysqli_error($connection));

}elseif (isset($_POST['Livello'])) {
  
    $username = $_POST['Username'];

    $livello = $_POST['Livello'];

    if($query = mysqli_query($connection, "CALL su_update_user('$username','','','$livello')")){

        echo json_encode("Utente promosso!");

    }else echo json_encode("Errore:".mysqli_error($connection));

}else echo json_encode(error_reporting(E_ALL));




mysqli_close($connection);

?>