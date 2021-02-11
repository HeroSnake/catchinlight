<?php
require_once "core_BO.php";
$categorie_id = $_GET['cat'];
$page = $_GET['page'];

//Supprime la page PHP
unlink('../' . $page . '.php');

//Vide le dossier
array_map( 'unlink', array_filter((array) glob("../img/". $page ."/*") ) );

//Supprime le dossier
rmdir('../img/' . $page);

//Supprimer la page de la BDD
$query_delete_page = $bdd->prepare("DELETE FROM categorie WHERE id = $categorie_id");
$query_delete_page->execute();

$query_delete_page = $bdd->prepare("DELETE FROM image WHERE category_id = $categorie_id");
$query_delete_page->execute();

header('location: gallery_liste.php');
