<?php

require_once('server.php');


    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmpassword'])) {
        
        $username = $_POST['username'];
     
        $email= $_POST['email'];
        $livello = $_POST['Livello'];
//Si controlla che l'email o lo username non siano già presenti nel database.
        $sql = mysqli_query($connection,"CALL su_select_utenti('$username','$email','')");

        mysqli_next_result($connection);

        if($row = mysqli_fetch_assoc($sql)){
           echo json_encode("L'email o lo username è già presente nel database!");
        }else{
      
      
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT); 
        $hash = password_hash(rand(0,1000), PASSWORD_DEFAULT);
        //Si inserisce l'utente all'interno del database
        if($query = mysqli_query($connection,"CALL su_insert_user('$username','$email','$password','$livello','$hash')")){
      
                //Si settano le variabili di sessione
                $_SESSION['username'] = $username;
               
                //Si settano le variabili per l'invio dell'email
                       
                $to = $email; //Destnatario
                $subject = 'Verifica la tua mail'; // Oggetto
                $message = '
                Abbiamo ricevuto la sua richiesta di iscrizione alla piattaforma UniHub.
                Le sue credenziali sono le seguenti.
                Username: '.$username.'
                Password: '.$_POST['password'].' 

                Per verificare la mail, la preghiamo di cliccare al seguente link
                https://localhost/uniHub/verify.php?email='.$email.'&hash='.$hash.'        
                '; 
                                             
                $headers = 'From:noreply@https://localhost/uniHub/index.php' . "\r\n"; 

                if(mail($to, $subject, $message, $headers)){
                    
                    echo json_encode("Utente registrato correttamente!");

                }else echo json_encode("Problema con l'invio dell'email");

               
            } else  echo json_encode('Errore nella query: '.mysqli_error($connection));
            
     

    }
           
        
    }
    

    mysqli_close($connection); 


?>