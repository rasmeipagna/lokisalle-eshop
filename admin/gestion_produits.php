<?php
include("../inc/init.inc.php");


/***************** SUPPRESSION ********************/
if(isset($_GET['action']) && $_GET ['action'] == 'suppression')
{
  $resultat = executeRequete("SELECT * FROM produit WHERE id_produit='$_GET[id_produit]'");
  $article_a_supprimer = $resultat->fetch_assoc();

  executeRequete("DELETE FROM produit WHERE id_produit='$_GET[id_produit]'");
  $_GET['action'] = 'affichage';
}
/***************** FIN SUPPRESSION ********************/

/***************** ENREGITREMENT PRODUIT********************/

if(isset($_POST['enregistrement']))
{
  foreach($_POST AS $indice => $valeur)
  {
    $_POST[$indice] = htmlentities($_POST[$indice], ENT_QUOTES);
  }
  extract($_POST);
  $reference_produit= executeRequete("SELECT * FROM produit WHERE id_produit = 'id_produit'");
  if($reference_produit->num_rows >0 && isset($_GET['action']) && $_GET['action'] == 'ajout')
  {
    $msg .='<div class="erreur"><p>Le produit est déjà existant. Veuillez vérifier vos saisies</p></div>';
  }
  if($reference_produit)
  {
    executeRequete("REPLACE INTO produit (id_produit, date_arrivee, date_depart, id_salle, prix) VALUES ('$id_produit','$date_arrivee', '$date_depart','$id_salle', '$prix')");
  }
  if(isset($_GET['action']) && $_GET['action'] == 'modification')
  {
    $msg .='<div class="confirm"><p>Le produit a bien été modifiée.</p></div>';
  }
  if(isset($_GET['action']) && $_GET['action'] == 'ajout')
  {
    $msg .='<div class="confirm"><p>Le produit a bien été ajouté.</p></div>';
  }

}
/***************** FIN ENREGITREMENT PRODUIT ********************/

include("../inc/header.inc.php");
include("../inc/nav.inc.php");
echo $msg;

?>

  	<section>
  		<body>
<div class="text">
	<div class="lien2">
  			<h1 class="titre">Gestion des Produits</h1>
  			<a id="lien1" href="?action=affichage" class="trans1">Afficher les produits</a>&nbsp;
  			<a id="lien1" href="?action=ajout" class="trans1">Ajouter un produit</a>
  	</div>
</div>

<?php
//*************AFFICHAGE DES PRODUITS *********************//
if(isset($_GET['action']) && $_GET['action'] =='affichage')
{
echo '<div class="text">';
  echo '<h1 class="titre2 lien2">Affichage des produits</h1>';
  $resultat = executeRequete("SELECT * FROM produit");
  echo '<p>Nombre de produits: '.$resultat->num_rows.'</p>';
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
    echo '<td><a href="?action=modification&id_produit='.$ligne['id_produit'].'"><img src="../images/modif.png" alt=""></a></td>';
    echo '<td><a href="?action=suppression&id_produit='.$ligne['id_produit'].'"onClick="return(confirm(\'En êtes vous certain ?\'));"><img src="../images/erase.png" alt="supprimer"></a></td>';
    echo '</tr>';
  }
  echo'</table>';
  echo '</div>';

}
//************* FIN AFFICHAGE DES PRODUITS *********************//
//************* AFFICHAGE DU FORMULAIRE *********************//
if(isset($_GET['action']) && ($_GET['action'] =='ajout' || $_GET['action'] =='modification'))
{
  if(isset($_GET['id_produit']['id_salle']))
  {
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = '$_GET[id_produit]'");
    $produit_actuel= $resultat->fetch_assoc();
  }

?>


		<h1 class="titre2 lien2">Ajouter un produit</h1>
        <form method="post" action="">

       <label for="id_produit">Référence</label>
        <input type="texte" name="id_produit" id="id_produit" value="<?php if(isset($produit_actuel['id_produit'])) { echo $produit_actuel['id_produit'];}?>" class="ligne"/><br />
        
        <label for="id_salle">Choisir une salle parmi les salles existantes</label>
        <select class="ligne" type="text" name="id_salle" id="id_salle" value="<?php if(isset($resultat['salle'])) { echo $resultat['titre'];}?>">
         
            <?php

            $resultat = executeRequete("SELECT * FROM salle"); // variable permettant d'appeler la table de la BDD
            while($salle = $resultat->fetch_assoc()) // attention a renommer une variable différent pour éviter qu'elle ne rentre en conflit avec la requete
            { 
            echo '<option>' .$salle['id_salle'].' - '.$salle['pays'] .' - '.$salle['ville'] .' - '.$salle['adresse'] .' - '.$salle['cp'] .' - '.$salle['titre'] .' - '.$salle['capacite'] .'- '.$salle['categorie'] .'</option>';
            }
            ?>

        </select><br />

        <label for="date_arrivee">Date d'arrivée</label>
        <input class="ligne" type="text" name="date_arrivee" id="date_arrivee" value="<?php if(isset($_POST['date_arrivee'])) { echo $_POST['date_arrivee']; }elseif(isset($produit_actuel['date_arrivee'])) { echo $produit_actuel['date_arrivee']; } ?>" placeholder="AAAA/MM/JJ 00:00:00"/><br />
        
        <label for="date_depart">Date de départ</label>
        <input class="ligne"  type="text" name="date_depart" id="date_depart" value="<?php if(isset($produit_actuel['date_depart'])) {echo $produit_actuel['date_depart']; }elseif(isset($produit_actuel['date_depart'])) { echo $produit_actuel['date_depart'];} ?>" placeholder="AAAA/MM/JJ 00:00:00"/><br />

        <label for="prix">Prix</label>
        <input class="ligne" type="text" name="prix" id="prix" value="<?php if(isset($produit_actuel['prix'])) {echo $produit_actuel['prix']; }elseif(isset($produit_actuel['prix'])) { echo $produit_actuel['prix'];} ?>"  /><br />

        <label for="etat">Etat</label>
        <select class="ligne" type="text" name="etat" id="etat" value="<?php if(isset($produit_actuel['etat'])) {echo $produit_actuel['etat']; }elseif(isset($produit_actuel['etat'])) { echo $produit_actuel['etat'];} ?>"  />
          <option>0</option>
          <option>1</option>
        </select><br />
        
        <label for="cp">Attribution remise parmi les codes promo existant </label>
        <select class="ligne" type="text" name="cp" id="cp" value="<?php if(isset($produit_actuel['cp'])) {echo $produit_actuel['cp']; }elseif(isset($produit_actuel['cp'])) { echo $produit_actuel['cp']; } ?>">
        </select><br /> 

		<input id="btn" name="enregistrement" type="submit" class="trans1" value="<?php echo ucfirst($_GET['action']);?>"/>
<?php
}
//*************FIN AFFICHAGE DU FORMULAIRE*********************//
?>
        </form> 

  		</body>

     </section>

<?php
include("../inc//admin_footer.inc.php");