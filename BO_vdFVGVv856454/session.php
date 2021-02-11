<?php
    $login_session = NULL;
    require_once '../db_connection.php';
    session_start();
    $logged = false;

    if(!isset($_SESSION['login_user'])){
        if($titre_page != "Connexion"){
            header("location: login");
            die();
        }
    }else {
        $logged = true;
        $user_check = $_SESSION['login_user'];
        $ses_sql = $bdd->prepare("select pseudo from compte where pseudo = '$user_check' ");
        $ses_sql->execute();
        while ($row = $ses_sql->fetch(PDO::FETCH_ASSOC)) {
            $login_session = $row['pseudo'];
        }
        if (!$ses_sql) {
            printf("Error: %s\n", mysqli_error($db));
            exit();
        }
    }
