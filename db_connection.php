<?php 
    $servername = "localhost";
    $username = "u956100313_catchinlightBD";
    $password = "Jpt1ve1fdp!";
    $database = "u956100313_catchinlight";

    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $database = "catchinlight";

    try{
        $bdd = new PDO('mysql:host='.$servername.';dbname='.$database.';charset=utf8', ''.$username.'', ''.$password.'');
    }
    catch(Exception $e){
            die('Erreur : '.$e->getMessage());
    }
