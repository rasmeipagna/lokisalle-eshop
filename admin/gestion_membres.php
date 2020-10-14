<?php
include("../inc/init.inc.php");

if(!utilisateurEstConnecteEtEstAdmin())
{
	header("location:../connexion.php");
	exit();
}
/***************** SUPPRESSION ********************/
if(isset($_GET['action']) && $_GET ['action'] == 'suppression')
{
  $resultat = executeRequete("SELECT * FROM membre WHERE id_membre='$_GET[id_membre]'");
  $membre_a_supprimer = $resultat->fetch_assoc();
  executeRequete("DELETE FROM membre WHERE id_membre='$_GET[id_membre]'");
  $_GET['action'] = 'affichage';
}
/***************** FIN SUPPRESSION ********************/
/***************** ENREGITREMENT MEMBRE********************/

if(isset($_POST['enregistrement']))
{
	foreach($_POST AS $indice => $valeur)
	{
		$_POST[$indice] = htmlentities($_POST[$indice], ENT_QUOTES);
	}
	extract($_POST);
	$reference_membre= executeRequete("SELECT * FROM membre WHERE id_membre = '$id_membre'");
	if($reference_membre->num_rows >0 && isset($_GET['action']) && $_GET['action'] == 'ajout')
	{
		$msg .='<div class="erreur"><p>La référence est déjà attribuée. Veuillez vérifier vos saisies</p></div>';
	}
	if(empty($msg))
	{
		executeRequete("INSERT INTO membre (id_membre, pseudo, mdp, nom, prenom, email, sexe, ville, cp, adresse, statut) VALUES ('$id_membre','$pseudo', '$mdp','$nom', '$prenom', '$email', '$sexe', '$ville', '$cp', '$adresse', '$statut')");
	}
  if(isset($_GET['action']) && $_GET['action'] == 'modification')
  {
    $msg .='<div class="confirm"><p>Le membre a bien été modifié.</p></div>';
  }
  if(isset($_GET['action']) && $_GET['action'] == 'ajout')
  {
    $msg .='<div class="confirm"><p>Le membre a bien été ajouté.</p></div>';
  }

}

/***************** FIN ENREGITREMENT MEMBRE ********************/

include("../inc/header.inc.php");
include("../inc/nav.inc.php");

?>

<section>
	<body>
		<div class="text">
			<div class="lien2">
       			<h1 class="titre">Gestion des Membres</h1>
			      <a id="lien1" href="?action=affichage" class="trans1">Afficher les membres</a>&nbsp;
			      <a id="lien1" href="?action=ajout" class="trans1">Création d'un nouveau compte administrateur</a>
  			</div>
		</div>


<?php
//*************AFFICHAGE DES MEMBRES *********************//
if(isset($_GET['action']) && $_GET['action'] =='affichage')
{
echo '<div class="text">';
  echo '<h1 class="titre2 lien2">Affichage des membres</h1>';
  $resultat = executeRequete("SELECT * FROM membre ORDER BY id_membre DESC");
  echo '<p>Nombre de membres: '.$resultat->num_rows.'</p>';
  echo '<table border="1">';
  
  echo '<tr>';
  while($titre = $resultat->fetch_field())
  {
    echo '<th>'.$titre->name.'</th>'; // première ligne contenant les noms de nos colonnes
  }
  echo '<th>Modif</th><th>Suppr</th></tr>';
  while($ligne = $resultat->fetch_assoc())
  {
    echo '<tr>';
    foreach($ligne AS $indice => $valeur)
    
     {
        echo '<td>'.$valeur.'</td>';
      }

    
    echo '<td><a href="?action=modification&id_membre='.$ligne['id_membre'].'"><img src="../images/modif.png" alt=""></a></td>';
    echo '<td><a href="?action=suppression&id_membre='.$ligne['id_membre'].'"onClick="return(confirm(\'En êtes vous certain ?\'));"><img src="../images/erase.png" alt="supprimer"></a></td>';
    echo '</tr>';
  }
  echo'</table>';
  echo '</div>';

}

//************* FIN AFFICHAGE DES ARTICLES *********************//
//************* AFFICHAGE DU FORMULAIRE *********************//
if(isset($_GET['action']) && ($_GET['action'] =='ajout' || $_GET['action'] =='modification'))
{
  if(isset($_GET['id_membre']))
  {
    $resultat = executeRequete("SELECT * FROM membre WHERE id_membre='$_GET[id_membre]'");
    $membre= $resultat->fetch_assoc();
  }
?>

		<h1 class="titre2 lien2">Ajouter un membre</h1>
       <form class ="text" method="post" action="#" enctype="multipart/form-data">
     			<label for="pseudo">Pseudo</label>
      			<input class="ligne" type="text" id="pseudo" name="pseudo" value="<?php if(isset($membre['pseudo'])) {echo $membre['pseudo']; }?>" placeholder="Votre pseudo..."/><br/>

      			<label for="password">Mot de passe</label>
      			<input class="ligne" type="password" id="password" name="mdp" value="<?php if(isset($membre['password'])) {echo $membre['password']; }?>"  placeholder="Votre mot de passe..."/><br/>

      			<label for="nom">Nom</label>
      			<input class="ligne" type="text" id="nom "name="nom" value="<?php if(isset($membre['nom'])) {echo $membre['nom']; }?>" placeholder="Nom"/><br/>

      			<label for="prenom">Prénom</label>
      			<input class="ligne" type="text" id="prenom "name="prenom" value="<?php if(isset($membre['prenom'])) {echo $membre['prenom']; }?>" placeholder="Prénom"/><br/>

      			<label for="email">Email</label>
      			<input class="ligne" type="text" id="email"name="email" value="<?php if(isset($membre['email'])) {echo $membre['email']; }?>" placeholder="Email"/><br/><br>

      			<label for="sexe">Sexe</label>
      			<input class="ok" type="radio" id="sexe" name="sexe" value="m"<?php if(isset($_POST['sexe']) && $_POST['sexe'] == "m"){echo 'checked';}elseif(!isset($_POST['sexe'])) {echo 'checked';} ?>/>Homme
      			<input class="ok" type="radio" id="sexe" name="sexe" value="f"<?php if(isset($_POST['sexe']) && $_POST['sexe'] == "f"){echo 'checked';} ?>/>Femme<br/><br>

      			<label for="adresse">Adresse</label>
        		<input type="text" name="adresse" id="adresse" value="<?php if(isset($_POST['adresse'])) {echo $_POST['adresse']; }elseif(isset($membre['adresse'])) { echo $membre['adresse'];} ?>" class="ligne" /><br />


      			<label for="ville">Ville</label>
      			<input class="ligne" type="text" id="ville" name="ville" value="<?php if(isset($membre['ville'])) {echo $membre['ville']; }?>" placeholder="Ville"/><br/>

      			<label for="cp">Code Postal</label>
      			<input class="ligne" type="text" id="cp" name="cp" value="<?php if(isset($membre['cp'])) {echo $membre['cp']; }?>" placeholder="Code Postal"/><br/>

      			<label for="statut">Statut</label>
      			<input class="ok" type="radio" id="statut" name="statut" value="1"<?php if(isset($_POST['statut']) && $_POST['statut'] == "1"){echo 'checked';}elseif(!isset($_POST['statut'])) {echo 'checked';} ?>/>Admin
      			<input class="ok" type="radio" id="statut" name="statut" value="0"<?php if(isset($_POST['statut']) && $_POST['statut'] == "0"){echo 'checked';} ?>/>Membre<br/><br>

      			<input id="btn" class="trans1" type="submit" name="enregistrement" value="<?php echo ucfirst($_GET['action']);?>" /><br/>


     </form>
    </div>
<?php
}
//*************FIN AFFICHAGE DU FORMULAIRE*********************//
?>
        </form> 

  	</body>
</section>

<?php
include("../inc//admin_footer.inc.php");