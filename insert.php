<?php

require_once('server.php');

if(isset($_POST['Titolo']) && isset($_POST['Contenuto']) && isset($_POST['Utente'])){
    
    $titolo = addslashes($_POST['Titolo']); 
    $contenuto = addslashes($_POST['Contenuto']);
    $utente = $_POST['Utente'];
    $tags = array();
    $tags = $_POST['Tags'];
    $codNotizia = $_POST['CodNotizia'];
    $codTag = $_POST['CodTag'];
    $aula = $_POST['Aula'];
    
    $dataAppello = $_POST['Data'];
    $dataAppello = date("Y-m-d H:i:s",strtotime($dataAppello));
    if($_POST['Categoria'] == "Appello") {$categoria = 1;}else {$categoria = 0;}
    $stringTags = implode(",",$tags);
    
    if($query = mysqli_query($connection, "CALL su_insert_notizia('$codNotizia','$titolo','$contenuto','$categoria','$aula','$dataAppello','$stringTags','$utente')")){
     
        foreach ($tags as $value) {

            mysqli_query($connection,"insert into tags(Id,Nome) value('$codTag','$value')");
            mysqli_query($connection,"insert into tagmap(Id_notizia,Id_tag) values('$codNotizia','$codTag')");
            $codTag++;
        }
        
        
        echo json_encode("Notizia postata correttamente!");
        
    }else echo json_encode("Errore: ".mysqli_error($connection));

}elseif (isset($_POST['Aula'])) {
    $cod = $_POST['Aula'];
    $utente = $_POST['Utente'];
    $dataAppello = strtotime($_POST['DataAppello']);
    $dataInizio = date('Y-m-d H:i:s',$dataAppello);
    $dataFine = date_create(date('Y-m-d H:i:s',$dataAppello));
    $durata = $_POST['Durata'];
    $polo = $_POST['Polo'];
    switch ($durata) {
        case '1':
       date_modify($dataFine,"+1 hours");
       $dataFine = date_format($dataFine,'Y-m-d H:i:s');
            break;
        case '2':
        date_modify($dataFine,"+2 hours");
        $dataFine = date_format($dataFine,'Y-m-d H:i:s');
            break;
        case '3':
        date_modify($dataFine,"+3 hours");
        $dataFine = date_format($dataFine,'Y-m-d H:i:s');
            break;
        case '4':
        date_modify($dataFine,"+4 hours");
        $dataFine = date_format($dataFine,'Y-m-d H:i:s');
            break;            
        
        default:
        date_modify($dataFine,"+2 hours");
        $dataFine = date_format($dataFine,'Y-m-d H:i:s');
            break;
    }
    
    if($query = mysqli_query($connection, "CALL su_prenota($cod,'$utente','$polo','$dataInizio','$dataFine')")){

        echo json_encode("Aula prenotata!");
    }else echo json_encode("Errore: ".mysqli_error($connection));

}elseif (isset($_POST['Titolo']) && isset($_POST['Bug'])) {
    
    $titolo = $_POST['Titolo'];
    $bug = $_POST['Bug'];
    $utente = $_POST['Utente'];
    if($query = mysqli_query($connection, "CALL su_report('$titolo','$bug','$utente')") ){

        echo json_encode("Report effettuato!");
    }else echo json_encode("Errore: ".mysqli_error($connection));

}elseif (isset($_POST['Nome']) && isset($_POST['Polo'])) {
    $aula = $_POST['Nome'];
    $polo = $_POST['Polo'];
    $locazione = $_POST['Polo'];

    if($query = mysqli_query($connection,"CALL su_insert_aula('$aula','$polo','$locazione')")){

        echo json_encode("L'aula è stata aggiunta al database!");
        
    }else echo json_encode("Errore: ".mysqli_error($connection));
}

mysqli_close($connection);
?>