<?php
session_start();
require_once(realpath(dirname(__FILE__)) . '/Utente.php');
//require_once(realpath(dirname(__FILE__)) . '/GestoreUtente.php');
//use Utente;
//use GestoreUtente;

/**
 * @access public
 * @author mariol96
 */
class GestoreAccessi {
	/**
	 * @AssociationType Utente
	 * @AssociationMultiplicity 1
	 */
	//public $unnamed_Utente_;
	/**
	 * @AssociationType GestoreUtente
	 * @AssociationMultiplicity 1
	 */
	//public $unnamed_GestoreUtente_;

	/**
	 * @access public
	 */
	public function login() {
		//require_once('server.php');
		$connection = mysqli_connect('localhost', 'root', '', 'su_db');
		$_SESSION['message'] ='';
		if (isset($_POST['usernameLogin']) && isset($_POST['passwordLogin'])){
		  //legge l'username in entrata dal form
		
		  $username = $_POST['usernameLogin'];
		  
		  
		
		if($result =  mysqli_query($connection,"CALL su_select_utenti('$username','','')")){
		
		
		
		  if ($row = mysqli_fetch_assoc($result)) {
			if(password_verify($_POST['passwordLogin'],$row['Password'])){
			//$livelloAutorizzativo = $row['LivelloAutorizzativo'];
			  $_SESSION['username'] = $username;
			  header ("Location: index.php");
			}else  $_SESSION['message'] = 'Username o Password errati';
		  } else {
			  $_SESSION['message'] = 'Username o Password errati';
		   
		  }
		
		  mysqli_close($connection);
		  
		}
		}
	}

	/**
	 * @access public
	 */
	public function logout() {
		// se la "distruzione" dei dati registrati nella stessa sessione va a buon fine, ritorna sulla pagina Login.
		if(session_destroy())
		{
		header("Location: Login.php");
		}
	}

	/**
	 * @access public
	 * @param string aUsername
	 * @param string aEmail
	 * @param string aPassword
	 * @return void
	 * @ParamType aUsername string
	 * @ParamType aEmail string
	 * @ParamType aPassword string
	 * @ReturnType void
	 */
	public function registrautente($aUsername, $aEmail, $aPassword) {
		// Not yet implemented
	}
}
?>