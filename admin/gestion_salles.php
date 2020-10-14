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
  $resultat = executeRequete("SELECT * FROM salle WHERE id_salle='$_GET[id_salle]'");
  $article_a_supprimer = $resultat->fetch_assoc();
  $chemin_photo = RACINE_SERVER . $article_a_supprimer['photo'];

  if(!empty($article_a_supprimer['photo']) && file_exists($chemin_photo))
  {
    unlink($chemin_photo);
  }
  executeRequete("DELETE FROM salle WHERE id_salle='$_GET[id_salle]'");
  $_GET['action'] = 'affichage';
}
/***************** FIN SUPPRESSION ********************/


/***************** ENREGITREMENT SALLE********************/

if(isset($_POST['enregistrement']))
{
	foreach($_POST AS $indice => $valeur)
	{
		$_POST[$indice] = htmlentities($_POST[$indice], ENT_QUOTES);
	}
	extract($_POST);
	$reference_article= executeRequete("SELECT * FROM salle WHERE id_salle = '$id_salle'");
	if($reference_article->num_rows >0 && isset($_GET['action']) && $_GET['action'] == 'ajout')
	{
		$msg .='<div class="erreur"><p>La référence est déjà attribuée. Veuillez vérifier vos saisies</p></div>';
	}else{
    $photo = "";
    
    if(isset($_GET['action']) && $_GET['action'] == 'modification')
    {
      $photo = $_POST['photo_actuelle'];
    }

    if(!empty($_FILES['photo']['name']))
    {
     if(verificationExtensionPhoto())
     {
      $nom_photo = $_POST['id_salle'].'_'.$_FILES['photo']['name'];
      $photo = RACINE_SITE . "photo/$nom_photo";
      $photo_dossier = RACINE_SERVER . RACINE_SITE . "photo/$nom_photo";
      copy($_FILES['photo']['tmp_name'], $photo_dossier);
     } 
     else{
      $msg .='<div class="erreur"><p>L\'extension n\'est pas valide. Extension acceptées : png / gif / jpg / jpeg !</p></div>';
     }
    }
	}
	if(empty($msg))
	{
		executeRequete("REPLACE INTO salle (id_salle, pays, ville, adresse, cp, titre, description, photo, capacite, categorie) VALUES ('$id_salle','$pays', '$ville','$adresse', '$cp', '$titre', '$description', '$photo', '$capacite', '$categorie')");
	}
  if(isset($_GET['action']) && $_GET['action'] == 'modification')
  {
    $msg .='<div class="confirm"><p>La salle a bien été modifiée.</p></div>';
  }
  if(isset($_GET['action']) && $_GET['action'] == 'ajout')
  {
    $msg .='<div class="confirm"><p>La salle a bien été ajoutée.</p></div>';
  }

}

/***************** FIN ENREGITREMENT SALLE ********************/

include("../inc/header.inc.php");
include("../inc/nav.inc.php");
echo $msg;

?>

  	<section>
  		<body>
			
<div class="text">
	<div class="lien2">
       <h1 class="titre">Gestion des Salles</h1>
      <a id="lien1" href="?action=affichage" class="trans1">Afficher les salles</a>&nbsp;
      <a id="lien1" href="?action=ajout" class="trans1">Ajouter une salle</a>
  </div>
</div>


<?php
//*************AFFICHAGE DES ARTICLES *********************//
if(isset($_GET['action']) && $_GET['action'] =='affichage')
{
echo '<div class="text">';
  echo '<h1 class="titre2 lien2">Affichage des salles</h1>';
  $resultat = executeRequete("SELECT * FROM salle ORDER BY id_salle DESC");
  echo '<p>Nombre de salles: '.$resultat->num_rows.'</p>';
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
      if($indice == 'photo') // $indice est strictement égal à photo
      {
        echo '<td><img src="'.$valeur.'" width="150"></td>'; // on insère un img src et la valeur correspondante à la photo pour afficher la photo
      }else{
        echo '<td>'.$valeur.'</td>';
      }

    }
    echo '<td><a href="?action=modification&id_salle='.$ligne['id_salle'].'"><img src="../images/modif.png" alt=""></a></td>';
    echo '<td><a href="?action=suppression&id_salle='.$ligne['id_salle'].'"onClick="return(confirm(\'En êtes vous certain ?\'));"><img src="../images/erase.png" alt="supprimer"></a></td>';
    echo '</tr>';
  }
  echo'</table>';
  echo '</div>';

}
//************* FIN AFFICHAGE DES ARTICLES *********************//
//************* AFFICHAGE DU FORMULAIRE *********************//
if(isset($_GET['action']) && ($_GET['action'] =='ajout' || $_GET['action'] =='modification'))
{
  if(isset($_GET['id_salle']))
  {
    $resultat = executeRequete("SELECT * FROM salle WHERE id_salle='$_GET[id_salle]'");
    $article_actuel= $resultat->fetch_assoc();
  }
?>

		<h1 class="titre2 lien2">Ajouter une salle</h1>
        <form method="post" action="" enctype="multipart/form-data">
        <!-- l'attribut enctype="multipart/form-data" est obligatoire en cas d'upload de fichier -->
        <label for="id_salle">Référence</label>
        <input type="text" name="id_salle" id="id_salle" value="<?php if(isset($article_actuel['id_salle'])) { echo $article_actuel['id_salle'];}?>" class="ligne"/><br />

        <label for="pays">Pays</label>
        <input type="text" name="pays" id="pays" value="<?php if(isset($_POST['pays'])) { echo $_POST['pays']; }elseif(isset($article_actuel['pays'])) { echo $article_actuel['pays']; } ?>" class="ligne" /><br />
        
        <label for="ville">Ville</label>
        <input type="text" name="ville" id="ville" value="<?php if(isset($_POST['ville'])) {echo $_POST['ville']; }elseif(isset($article_actuel['ville'])) { echo $article_actuel['ville'];} ?>" class="ligne" /><br />

        <label for="adresse">Adresse</label>
        <input type="text" name="adresse" id="adresse" value="<?php if(isset($_POST['adresse'])) {echo $_POST['adresse']; }elseif(isset($article_actuel['adresse'])) { echo $article_actuel['adresse'];} ?>" class="ligne" /><br />
        
        <label for="cp">Code Postal</label>
        <input type="text" name="cp" id="cp" value="<?php if(isset($_POST['cp'])) {echo $_POST['cp']; }elseif(isset($article_actuel['cp'])) { echo $article_actuel['cp']; } ?>" class="ligne" /><br />

        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" value="<?php if(isset($_POST['titre'])) {echo $_POST['titre']; }elseif(isset($article_actuel['titre'])) { echo $article_actuel['titre']; } ?>" class="ligne" /><br><br><br>

        <label for="cp">Description</label>
        <textarea type="text" name="description" id="description" class="ligne" ><?php if(isset($_POST['description'])) {echo $_POST['description']; }elseif(isset($article_actuel['description'])) { echo $article_actuel['description']; } ?></textarea><br><br><br>
        
         <label >Photo</label>
        <input type="file" name="photo" class="ligne" /><br />
        <?php
        if(isset($article_actuel))
        {
          echo '<label for="prix">Photo Actuelle:</label><br/>';
          echo '<img class=imgcenter src="'.$article_actuel['photo'].'"width="140"/>';
          echo '<input type="hidden" name="photo_actuelle" value="'.$article_actuel['photo'].'"/>';
        }
        ?>

        <label for="capacite">Capacité</label>
        <input type="text" name="capacite" id="capacite" value="<?php if(isset($_POST['capacite'])) {echo $_POST['capacite']; }elseif(isset($article_actuel['capacite'])) { echo $article_actuel['capacite'];} ?>" class="ligne" /><br />

        <label for="categorie">Catégorie</label>
        <input type="text" name="categorie" id="categorie" value="<?php if(isset($_POST['categorie'])) {echo $_POST['categorie']; }elseif(isset($article_actuel['categorie'])) { echo $article_actuel['categorie'];} ?>" class="ligne" /><br />

        

		<input id="btn" name="enregistrement" type="submit" value="<?php echo ucfirst($_GET['action']);?>" class="trans1"/>
<?php
}
//*************FIN AFFICHAGE DU FORMULAIRE*********************//
?>
        </form> 

  		</body>
  		</section>

     

<?php
include("../inc//admin_footer.inc.php");