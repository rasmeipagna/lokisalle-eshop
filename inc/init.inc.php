<?php
// ce fichier permet l'initialisation du site. Il sera inclus sur toutes nos pages avec les fichiers minimum requis pour que le site puisse s'afficher correctement
include("connexion_bdd.inc.php");
include("fonction.inc.php");

session_start();
define("RACINE_SITE","/lokisalle/"); //permettra de ne pas avoir de problème de liens ou de chemin comme pour les styles par exemple.
define("RACINE_SERVER",$_SERVER['DOCUMENT_ROOT']); // permet d'avoir le chemin racine du serveur pour la copie notamment des photos. En récupérant la racine via $_SERVER: le chemin est automatisé. Ce sera toujours valide.

$msg = "";  // les messages à échanger avec l'internaute seront contenu dans cette variable