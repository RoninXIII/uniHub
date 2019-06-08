<?php 
require_once('server.php');

if(isset($_POST['Elimina_user'])){

    $codUtente = $_POST['Elimina_user'];
if($query = mysqli_query($connection, "CALL su_delete_user('$codUtente')")){

    echo json_encode("Eliminazione effettuata!");

}echo json_encode("Errore: ".mysqli_error($connection));

}elseif (isset($_POST['CodElimina'])) {
    $cod = $_POST['CodElimina'];

    if($query = mysqli_query($connection, "CALL su_delete_notizia('$cod')")){

        echo json_encode("Eliminazione effettuata!");

    }else echo json_encode("Errore: ".mysqli_error($connection));
}

mysqli_close($connection);


?>