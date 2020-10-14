<?php
include("inc/init.inc.php");
$mysqli = @new Mysqli("localhost:8889", "root", "root", "lokisalle") or die("oups : problème de connexion");
$resultat_salle = $mysqli->query("SELECT titre, photo, capacite, date_arrivee, date_depart, prix FROM salle s INNER JOIN produit p ON s.id_salle = p.id_salle WHERE s.id_salle = p.id_salle ORDER BY s.id_salle DESC LIMIT 0,3");
include("inc/header.inc.php");
include("inc/nav.inc.php");
?>

<section>
  <body>
<h1 class="titre">Nos Bureaux</h1>
    <div class="text">
    	 <!-- Début Sliders -->
            <div class="slider">
                <input type="radio" name="slide-switches" id="slide1" checked class="slide-switch">
                <label for="slide1" class="slide-label">Slide 1</label>
                    <div class="slide-content padded">
                        <img src="images/office1.jpg" alt="Salle 1">
                        
                    </div>

                <input type="radio" name="slide-switches" id="slide2" class="slide-switch">
                <label for="slide2" class="slide-label">Slide 2</label>
                    <div class="slide-content">
                      <img src="images/office2.jpg" alt="Salle 1">
                    </div>

                <input type="radio" name="slide-switches" id="slide3" class="slide-switch">
                <label for="slide3" class="slide-label">Slide 3</label>
                    <div class="slide-content">
                       <img src="images/office3.jpg" alt="Salle 3">
                    </div>

                <input type="radio" name="slide-switches" id="slide4" class="slide-switch">
                <label for="slide4" class="slide-label">Slide 4</label>
                    <div class="slide-content">
                       <img src="images/office4.jpg" alt="Salle 4">
                    </div>
             
            </div>
      <!-- Fin Slider-->
      <p>LokiSalle vous propose un service de location de salle pour l'organisation de vos réunions, séminaires, formations ou autres événements, que vous soyez particuliers ou professionnels.<br>Situées dans les quartiers d'affaire des villes de Paris, Lyon et Marseille, toutes nos salles sont parfaitement desservies par les transports publics ou à proximité de gare SNCF.<br>Des professionnels d'organisation d'événements sont également présents sur le site pour vous faciliter toute l'organisation. Depuis la location de salles jusqu'à sa décoration en passant par l'animation sonore...<br>Lokisalle vous facilite vos recherches, n'hésitez pas à venir nous rendre visite ou réserver directement nos salles sur notre site !
 	</p>
  <h1 class="titre">Nos 3 dernieres nouveautes</h1>
  <div class="text center">

    <?php
while($s = $resultat_salle->fetch_assoc())
{
  echo '<div class="float">';
  echo '<h2 class="titre2">'.$s['titre'].'</h2>';
  echo '<p>'.'Pour '.$s['capacite'].' personnes.'.'</p>';
  echo '<img src="'.$s['photo'].'" width="280" height="200" /><br>';
  echo '<a id="lien1" class="trans1" href="reservation_details.php?id_produit=N">'.'Voir la fiche détaillée'.'</a>';
  echo '<p>'.'Date d\'arrivée : '.$s['date_arrivee'].'</p>';
  echo '<p>'.'Date de départ : '.$s['date_depart'].'</p>';
  echo '<p>'.'Prix : '.$s['prix'].'€'.'</p>';
  
  

  if(utilisateurEstConnecte()){
    echo '<a id="lien1" class="trans1" href="panier.php">'.'Ajouter au panier'.'</a><br>';
    echo '<hr>';
  }else{
  echo '<a id="lien1" class="trans1" href="connexion.php">'.'Connectez-vous pour l\'ajouter au panier'.'</a><br>';
  echo '<hr>';
  }
  echo '</div>';

}


    ?>

  </div>


    </div>
  </body>
</section>

<?php
include("inc/footer.inc.php");