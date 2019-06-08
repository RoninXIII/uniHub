<?php
require_once('server.php');

//Nella pagina principale sarà settata la variabile Notizie per poter vedere tutte le notizi.
if(isset($_POST['Notizie'])){
    //Preferenze dell'utente
$preferenze = $_POST['Preferenze'];
if($queryNotizie = mysqli_query($connection, "CALL su_select_notizie('$preferenze')")){
    $notizie = array();

//Si conservano in un array tutte le notizie selezionate dalla query.
    while($row = mysqli_fetch_assoc($queryNotizie)){
        $notizie[] = array("Cod" => $row['Cod'], "Oggetto" => $row['Nome'], "Contenuto" => $row['Descrizione'], "Tags" => $row['Tags'],
        "Data_pubblicazione" => date('d-m-Y H:i:s',strtotime($row['DataPubblicazione'])),"Appello" => $row['Appello'],"Aula" => $row['Aula'],"Ora" => $row['DataAppello'],
        "Mittente" => $row['Utente']);
    }
  
    echo json_encode($notizie);

}else echo json_encode("Errore: ".mysqli_error($connection)); // Stampa un errore relativo a mysql

//Dalla pagina Aule.php o Index.php
}elseif (isset($_POST['Aule'])) {
//Se la variabile utente è settata allora la richiesta http viene effettuata dalla pagina principale, in quanto si devono mostrare nella form
//solo le aule selezionate dall'utente che sta usando l'applicazione.
    if(isset($_POST['Utente'])){
    $utente = $_POST['Utente'];

    if($queryAulePrenotate = mysqli_query($connection,"CALL su_select_aule('$utente')")){
      
        $aulePrenotate = array();
        while($row = mysqli_fetch_assoc($queryAulePrenotate)){
            $aulePrenotate[] = array("cod" =>$row['Cod'], "nome" =>$row['Nome'], "polo" =>$row['Polo'], "locazione" =>$row['Locazione']);
        }
        
        echo json_encode($aulePrenotate);
            }else echo json_encode("Errore: ".mysqli_error($connection));

    }else{
        //Altrimenti la richiesta http viene effettuata dalla pagina Aule.php e si selezionano tutte le aule presenti nel database.

        if($queryAule = mysqli_query($connection,"CALL su_select_aule('')")){
            $aule = array();
            while($row = mysqli_fetch_assoc($queryAule)){
                $aule[] = array("cod" =>$row['Cod'], "nome" =>$row['Nome'], "polo" =>$row['Polo'], "locazione" =>$row['Locazione']);
            }

            echo json_encode($aule);

        }else echo json_encode("Errore: ".mysqli_error($connection));
    }

}elseif(isset($_POST['Utenti']) && isset($_POST['Bugs']) ) {
    
    if($queryUtenti = mysqli_query($connection,"CALL su_select_utenti('','','')")){
        mysqli_next_result($connection);

        $utenti = array();

        while($row = mysqli_fetch_assoc($queryUtenti)){
            $utenti[] = array("cod" =>$row['Cod'], "username" =>$row['Username'], "email" =>$row['Email'], "livello" =>$row['LivelloAutorizzativo']);
        }

 
        if($queryBugs = mysqli_query($connection, "CALL su_select_bugs()")){

            $bugs = array();

            while($row2 = mysqli_fetch_assoc($queryBugs)){
             $bugs[] = array("cod" => $row2['Cod'], "titolo" => $row2['Nome'], "descrizione" => $row2['Descrizione'], "data" => $row2['Data'], "utente" => $row2['Utente']);   
            }
        } else echo json_encode("Errore: ".mysqli_error($connection));
       
    

        echo json_encode([$utenti,$bugs]);

    }else echo json_encode("Errore: ".mysqli_error($connection));
}elseif (isset($_POST['Polo'])) {

    if($queryPoli =mysqli_query($connection,"CALL su_select_poli()")){
        $poli= array();

        while($row = mysqli_fetch_assoc($queryPoli)){
            $poli[] = array("polo" =>$row['Polo']);
        }
    }
    
    echo json_encode($poli);
    
} else echo json_encode(error_reporting(E_ALL));


mysqli_close($connection);

?>