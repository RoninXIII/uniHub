<?php

require_once('server.php');


    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmpassword'])) {
        
        $username = $_POST['username'];
     
        $email= $_POST['email'];

        $sql = mysqli_query($connection,"CALL su_select_utenti('$username','$email','')");

        mysqli_next_result($connection);

        if($row = mysqli_fetch_assoc($sql)){
           echo json_encode("L'email o lo username è già presente nel database!");
        }else{
      

        $password = md5($_POST['password']); //md5 has password for security
        $hash = md5( rand(0,1000) );
        
        if($query = mysqli_query($connection,"CALL su_insert_user('$username','$email','$password','$hash')")){
            mysqli_next_result($connection);
                //set session variables
                $_SESSION['username'] = $username;
               
                //insert user data into database
                       
                $to = $email; // Send email to our user
                $subject = 'Verifica la tua mail'; // Give the email a subject 
                $message = '
                Abbiamo ricevuto la sua richiesta di iscrizione alla piattaforma di visualizzazione del Piano Strategico.
                Le sue credenziali sono le seguenti.
                Username: '.$username.'
                Password: '.$_POST['password'].'

                Per verificare la mail, la preghiamo di cliccare al seguente link
                https://localhost/App_ingegneria_del_software/verify.php?email='.$email.'&hash='.$hash.'        
                '; // Our message above including the link
                                             
                $headers = 'From:noreply@https://localhost/App_ingegneria_del_software/index.php' . "\r\n"; // Set from headers

                if(mail($to, $subject, $message, $headers)){
                    
                    echo json_encode("Utente registrato correttamente!");

                }else echo json_encode("Problema con l'invio dell'email");

               
            } else  echo json_encode('Errore nella query: '.mysqli_error($connection));
            
     

    }
           
        
    }
    

    mysqli_close($connection); 


?>