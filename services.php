<?php // pour la page maître
$pageName = basename(__FILE__);
$titre_page = "Services";
$meta_description = "Liste des services proposés";
require_once "corePage.php"; 
//Récupérer services
$query_services = $bdd->prepare("SELECT * FROM `services` WHERE visible = 1");
$query_services->execute();
?>

<div class="container text-center row mx-auto">
    <?php while ($row = $query_services->fetch(PDO::FETCH_ASSOC)) { ?>
        <div class="col-9 row flip rounded shadow border mb-2 mx-auto px-0 my-3" id="section<?=$row['section']?>">
            <div class="col-12 py-1 px-0">
                <h2><small class="fas <?=$row['icon']?>"></small> <?=$row['titre']?> <!--<small class="fas fa-caret-down"></small> --> </h2>
            </div>
            <div class="panel px-auto">
                <p>
                    <?=$row['description']?>
                </p>
                <p class="text-right">
                    <small>
                        Intéressé(e) ? <a class="link" href="contact"><b>Contactez-moi !</b></a> 
                    </small>
                </p>
            </div>
        </div>
    <?php
    }
    ?>
</div>

<?php require_once "endPage.php"; ?>