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
        $notizie[] = array("Cod" => $row['Cod'], "Oggetto" => $row['Nome'], "Contenuto" => $row['Descrizione'],"Tags" => $row['Tags'],
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

    if($queryAulePrenotate = mysqli_query($connection,"CALL su_select_aule('$utente','','','')")){
      
        $aulePrenotate = array();
        while($row = mysqli_fetch_assoc($queryAulePrenotate)){
            $aulePrenotate[] = array("aula" =>$row['Aula'], "polo" =>$row['Polo'], "locazione" =>$row['Locazione'], "dataPrenotazione" => $row['DataAppello']);
        }
        
        echo json_encode($aulePrenotate);

            }else echo json_encode("Errore: ".mysqli_error($connection));

    }else{

        if($_POST['Aule'] == "1"){

            if($queryAule =mysqli_query($connection,"SELECT * FROM aule order by Polo")){
                $aule= array();
        
                while($row = mysqli_fetch_assoc($queryAule)){
                    $aule[] = array("cod" => $row['Cod'],"nome" => $row['Nome'], "polo" => $row['Polo'], "locazione" => $row['Locazione']);
                }

                echo json_encode($aule);

            }else echo json_encode("Errore: ".mysqli_error($connection));
        } else {
  
        $dataAppello = strtotime($_POST['DataAppello']);
        $dataInizio = date('Y-m-d H:i:s',$dataAppello);
        $dataFine = date_create(date('Y-m-d H:i:s',$dataAppello));
        $durata = $_POST['Durata'];

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

        $polo = $_POST['Polo'];

        if($queryAule = mysqli_query($connection,"CALL su_select_aule('','$polo','$dataInizio','$dataFine')")){
            $aule = array();
            while($row = mysqli_fetch_assoc($queryAule)){
                $aule[] = array("cod" =>$row['Cod'], "nome" =>$row['Nome'], "polo" =>$row['Polo'], "locazione" =>$row['Locazione']);
            }



            echo json_encode($aule);
        

        }else echo json_encode("Errore: ".mysqli_error($connection));
    }
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
    
}elseif (isset($_POST['Account'])) {
    $tags = array();
    if($queryTags = mysqli_query($connection,"SELECT Nome from tags")){

        while ($row = mysqli_fetch_assoc($queryTags)) {
            $tags[] = array("nome" =>$row['Nome']);
        }
        echo json_encode($tags);
    }else echo json_encode("Errore: ".mysqli_error($connection));

} else echo json_encode(error_reporting(E_ALL));


mysqli_close($connection);

?>