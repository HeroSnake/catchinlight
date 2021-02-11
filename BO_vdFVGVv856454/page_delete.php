<?php
require_once "core_BO.php";
$page_id = $_GET['cat'];

//Supprime la page PHP
unlink('../' . $page . '.php');

//Supprimer la page de la BDD
$query_create_page = $bdd->prepare("DELETE FROM pages WHERE id = $page_id");
$query_create_page->execute();

header('location: page_liste.php');
