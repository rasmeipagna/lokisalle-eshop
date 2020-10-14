<?php
include("inc/init.inc.php");
if(isset($_GET['action']) && $_GET['action']== 'deconnexion')
{
  session_destroy();
}

if(utilisateurEstConnecte())
{
  header("location:profil.php");
}
if($_POST)
{
	foreach($_POST AS $indice => $valeur)
			{
				$_POST[$indice] = htmlentities($_POST[$indice], ENT_QUOTES);
			}
			extract($_POST);
			$selection_membre = executeRequete("SELECT * FROM membre WHERE pseudo = '$pseudo' AND mdp='$mdp'");
			if($selection_membre->num_rows != 0)
			{
        		$membre = $selection_membre->fetch_assoc();
        		foreach($membre AS $indice => $valeur)
        		{
		          if($indice != 'mdp')
		          {
		          $_SESSION['utilisateur'][$indice] = $valeur;
		          }
        	}
        header("location:profil.php");
			}
			else{
				$msg .='<div class="erreur"><p>Votre pseudo ou votre mot de passe n\'est pas correct. Veuillez recommencer</p></div>';
			}
}
include("inc/header.inc.php");
include("inc/nav.inc.php");
echo $msg;
?>

  		<section>
  			<body>
          
  				<h1 class="titre">Connexion</h1>
  				<h2 class="titre2 lien2">Déjà membre ?</h2>
  				<form method="post" action="">
      			<label for="pseudo">Pseudo</label>
      			<input type="text" id="pseudo" name="pseudo" value="<?php if(isset($_POST['pseudo'])) {echo $_POST['pseudo']; }?>" class="ligne" placeholder="pseudo..."/><br/>

      			<label for="password">Mot de passe</label>
      			<input type="password" id="password" name="mdp" value="" class="ligne" placeholder="mot de passe..."/><br/>

      			<input id="btn" name="inscription" type="submit" value="Connexion" class="trans1"/><br/>
            
      		</form>

          <div class="lien2">
            <h2 class="titre2">Pas encore membre ?</h2>
            <a href="inscription.php" class="trans1">Inscrivez- vous !</a>
          </div>
          
  			</body>

      </section>

<?php
include("inc/footer.inc.php");