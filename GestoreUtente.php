<?php
require_once(realpath(dirname(__FILE__)) . '/GestoreAccessi.php');

use GestoreAccessi;

/**
 * @access public
 * @author mariol96
 */
class GestoreUtente {
	/**
	 * @AssociationType GestoreAccessi
	 * @AssociationMultiplicity 1
	 */
	public $unnamed_GestoreAccessi_;

	/**
	 * @access public
	 * @param string aNewPassword
	 * @ParamType aNewPassword string
	 */
	public function modificaPassword($aNewPassword) {
		// Not yet implemented
	}

	/**
	 * @access public
	 * @param string aNewEmail
	 * @ParamType aNewEmail string
	 */
	public function modificaEmail($aNewEmail) {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function eliminaProfilo() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function mostraProfilo() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function modificaPreferenze() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function modificaImpostazioniHub() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function visualizzaHub() {
		// Not yet implemented
	}

	/**
	 * @access public
	 */
	public function postaNotizia() {
		// Not yet implemented
	}
}
?>