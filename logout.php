<?php
  require_once(realpath(dirname(__FILE__)) . '/GestoreAccessi.php');
  session_start();
  $_SESSION['gestoreAccessi'] -> logout();


?>