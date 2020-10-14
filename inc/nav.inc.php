 <nav>
	<ul>
            <?php if(utilisateurEstConnecte()) {?>
            
            <li><a id="lien1" class="trans1 <?php active('/lokisalle/index.php');?>" href="<?php echo RACINE_SITE;?>index.php">Accueil</a></li>
            <li><a id="lien1" class="trans1 <?php active('/lokisalle/reservation.php');?>" href="<?php echo RACINE_SITE;?>reservation.php">Reservation</a></li>
            <li><a id="lien1" class="trans1 <?php active('/lokisalle/recherche.php');?>" href="<?php echo RACINE_SITE;?>recherche.php">Recherche</a></li>
            <li><a id="lien1" class="trans1 <?php active('/lokisalle/panier.php');?>" href="<?php echo RACINE_SITE;?>panier.php">Panier</a></li>
            <li><a id="lien1" class="trans1 <?php active('/lokisalle/profil.php');?>" href="<?php echo RACINE_SITE;?>profil.php">Profil</a></li>
            <li><a id="lien1" class="trans1 <?php active('/lokisalle/connexion.php');?>" href="<?php echo RACINE_SITE;?>connexion.php?action=deconnexion">Deconnexion</a></li>
            
            <?php }else{ ?>

            <li><a id="lien1" class="trans1 <?php active('/lokisalle/index.php');?>" href="<?php echo RACINE_SITE;?>index.php">Accueil</a></li>
            <li><a id="lien1" class="trans1 <?php active('/lokisalle/reservation.php');?>" href="<?php echo RACINE_SITE;?>reservation.php">Reservation</a></li>
            <li><a id="lien1" class="trans1 <?php active('/lokisalle/recherche.php');?>" href="<?php echo RACINE_SITE;?>recherche.php">Recherche</a></li>
            <li><a id="lien1" class="trans1 <?php active('/lokisalle/connexion.php');?>" href="<?php echo RACINE_SITE;?>connexion.php">Connexion</a></li>
            <li><a id="lien1" class="trans1 <?php active('/lokisalle/inscription.php');?>" href="<?php echo RACINE_SITE;?>inscription.php">Inscription</a></li>

            <?php } ?>
</ul>
<ul>
            <?php if(utilisateurEstConnecteEtEstAdmin())
            {
              echo '<li ("/lokisalle/index.php");><a id="lien1" class="trans1" href="'.RACINE_SITE.'admin/gestion_salles.php">Gestion Salles</a></li>';
              echo '<li ("/lokisalle/index.php");><a id="lien1" class="trans1" href="'.RACINE_SITE.'admin/gestion_avis.php">Gestion Avis</a></li>';
              echo '<li ("/lokisalle/index.php");><a id="lien1" class="trans1" href="'.RACINE_SITE.'admin/gestion_produits.php">Gestion Produits</a></li>';
              echo '<li ("/lokisalle/index.php");><a id="lien1" class="trans1" href="'.RACINE_SITE.'admin/gestion_promos.php">Gestion Code Promos</a></li>';
              echo '<br>';
              echo '<li ("/lokisalle/index.php");><a id="lien1" class="trans1" href="'.RACINE_SITE.'admin/gestion_membres.php">Gestion Membres</a></li>'; 
              echo '<li ("/lokisalle/index.php");><a id="lien1" class="trans1" href="'.RACINE_SITE.'admin/gestion_commandes.php">Gestion Commandes</a></li>';
              echo '<li ("/lokisalle/index.php");><a id="lien1" class="trans1" href="'.RACINE_SITE.'admin/statistiques.php">Statistiques</a></li>';
              echo '<li ("/lokisalle/index.php");><a id="lien1" class="trans1" href="'.RACINE_SITE.'admin/envoi_newsletter.php">Envoyer la newsletter</a></li>';
            }
            ?>
 	</ul>
 </nav>