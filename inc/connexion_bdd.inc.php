<?php

$mysqli = @new Mysqli("localhost:8889", "root", "root", "lokisalle");
if($mysqli->connect_error)
{
	die("Oups ! Un probleme est survenu lors de la tentative de connexion a la BDD: ".$mysqli->connect_error);
}