<?php

require_once(realpath(dirname(__FILE__)) . '/Utente.php');
  require_once('server.php');


  if(isset($_POST['Username']) && isset($_POST['Email'])){

        $username = $_POST['Username'];
        $email=$_POST['Email'];
        $operazione = "Elimina_utente";
                                                                //(username,email,password,livello,verCode,preferenze,operazione)
        if($query = mysqli_query($connection,"CALL su_modify_utente('$username','','','','','','$operazione')")){
          mysqli_next_result($connection);    
       $to = $email; // Send email to our user
       $subject = 'Eliminazione Account'; // Give the email a subject 
       $message = '
       La sua richiesta (o dell\'admin) di eliminazione del profilo è stata ricevuta.
       Abbiamo provveduto a rimuovere l\'account dal database.
              
       '; // Our message above including the link
                                    
       $headers = 'From:noreply@https://localhost/uniHub/index.php' . "\r\n"; // Set from headers

       if(mail($to, $subject, $message, $headers)){ // Send our email
        
       
        echo json_encode("Utente eliminato correttamente!");

       
       }
       
      }else echo json_encode('Errore nella query: '.mysqli_error($connection));
      
       //Modifica del livello autorizzativo da parte dell'admin(Dashboard.php)
       }else if(isset($_POST['Username']) && isset($_POST['Livello'])){
       
         $username = $_POST['Username'];
         $livello = $_POST['Livello'];
         $operazione = "Modifica_livello";
        
                                                                    //(username,email,password,livello,verCode,preferenze,operazione)
         if($query = mysqli_query($connection, "CALL su_modify_utente('$username', '', '', '$livello', '', '', '$operazione')")){
   
          $_SESSION['utente']->setLivello($livello);

          echo json_encode("Livello autorizzativo modificato con successo!");
       

         }else echo json_encode('Errore nella query: '.mysqli_error($connection));
       
       //Recupero della password dell'utente(Login.php)
       }else if(isset($_POST['Email'])){
       
         $emailRecoverPswd = $_POST['Email'];
         $codiceVerifica=rand(0, 1000);
         $hashCodiceVerifica= md5($codiceVerifica);
         $operazione = "Recupero_password";
                                                                      //(username,email,password,livello,verCode,preferenze,operazione)
         if ($query = mysqli_query($connection,"CALL su_modify_utente ('','$emailRecoverPswd','$hashCodiceVerifica','','','','$operazione')")) {
          
          
           $to = $emailRecoverPswd; 
       
           $subject = 'RECUPERO PASSWORD';  
         
           $message = '
                    
           
           Si è richiesto il recupero della password.
           
                    
           Il codice per accedere al sito è il seguente, ti invitiamo a modificarla nell\'apposita pagina :
           -------------------    
           '.$codiceVerifica.'
           -------------------         
           '; 
                                        
           $headers = 'From:noreply@https://localhost/uniHub/index.php' . "\r\n"; 
         
           
           
            if(mail($to, $subject, $message, $headers)){
       
           echo json_encode('Codice di verifica inviato con successo!');

        
            }else echo json_encode('Errore nell\'invio dell\'email');
       
         }else{
       
          echo json_encode('Errore nella query: '.mysqli_error($connection));
       }
       
       }// MODIFICA DELLA PASSWORD (account.php)
       else if(isset($_POST['newPassword']) && isset($_POST['EmailPassword'])){

        $username = $_POST['Username'];

        $email = $_POST['EmailPassword'];
        $newHashPwsd = md5( rand(0,1000) );
        $newPswd= md5($_POST['newPassword']);
        $operazione = "Modifica_password";
                                                                  //(username,email,password,livello,verCode,preferenze,operazione)
        if($query = mysqli_query($connection, "CALL su_modify_utente('$username','','$newPswd','','$newHashPwsd','','$operazione')")){
        
          

        $to = $email; // Send email to our user
        $subject = 'Verifica la tua nuova password!'; // Give the email a subject 
        $message = '
        Ci è stata notificata la sua rischiesta di modifica della password. La sua nuova password è:
        '.$_POST['newPassword'].'

        Per continuare a navigare sul nostro sito, è pregato di riconfermare il suo account tramite il seguente link
        https://localhost/uniHub/verify.php?email='.$email.'&hash='.$newHashPwsd.'

   '; // Our message above including the link
                                
        $headers = 'From:noreply@https://localhost/uniHub/index.php' . "\r\n"; // Set from headers

        if(mail($to, $subject, $message, $headers)){ // Send our email
        
                 
     echo json_encode("Password modificata!");

    } else echo json_encode("Errore nell'invio dell'email");


          } else echo json_encode('Errore nella query: '.mysqli_error($connection));
          
       
       }else if(isset($_POST['Preferenze'])){

        $username = $_POST['Username'];
        $preferenze = implode(',',$_POST['Preferenze']);
        $operazione = "Modifica_preferenze";
        if($query = mysqli_query($connection, "CALL su_modify_utente('$username','','','','','$preferenze','$operazione')")){
          
          $_SESSION['utente']->setPreferences($preferenze);
        
          echo json_encode("Preferenze modificate!");

        }else  echo json_encode('Errore nella query: '.mysqli_error($connection));

       }

      mysqli_close($connection);
?>