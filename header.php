

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="index.php"><img alt="Brand" src="LogoUnicam.png" height="35px" width="85px"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php"> <span class="fas fa-igloo"></span>&ensp;Home </a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="Logout.php"><span class="fas fa-door-open "></span>&ensp;Logout</a>
        </li>
       <!-- <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Dashboard</a>
        </li>-->
        <li class="nav-item active">
          <a class="nav-link" href="account.php"><span class="fas fa-user "></span>&ensp;Account</a>
        </li>
       <?php if($_SESSION['utente'] ->getLivello() != 0 ){?> <li class="nav-item active">
          <a class="nav-link" href="aule.php"><span class="fas fa-university"></span>&ensp;Aule</a>
        </li>
       <?php }?>
       <li class="nav-item active">
          <a class="nav-link" href="dashboard.php"><span class="fas fa-university"></span>&ensp;Dashboard</a>
        </li>
      </ul>
  
    </div>
  </nav>
