<?php
include("inc/init.inc.php");
if(!utilisateurEstConnecte())
{
  header("location:connexion.php"); 
}
include("inc/header.inc.php");
include("inc/nav.inc.php");
echo $msg;
?>

  		<section>
  			<body>
          <h1 class="titre">Votre Profil</h1>
          <div class="text">

<?php
 if(utilisateurEstConnecteEtEstAdmin($_SESSION['utilisateur']['statut']))
  {
  echo '<h1>Vous êtes administrateur</h1>';
  }
  else{
    echo '<h1>Vous êtes utilisateur</h1>';
  }

  echo'Votre Pseudo est : '.$_SESSION['utilisateur']['pseudo'] .'<br>';
  echo'Votre Nom est : '.$_SESSION['utilisateur']['nom'] .'<br>';
  echo'Votre Prénom est : '.$_SESSION['utilisateur']['prenom'] .'<br>';
  echo'Votre Email est : '.$_SESSION['utilisateur']['email'] .'<br>';
  echo'Votre Adresse est : '.$_SESSION['utilisateur']['adresse'] .'<br>';
  echo'Votre Code Postal est : '.$_SESSION['utilisateur']['cp'] .'<br>';
  echo'Votre Ville est : '.$_SESSION['utilisateur']['ville'] .'<br>';


?>

</div>

  			</body>

      </section>

<?php
include("inc/footer.inc.php");