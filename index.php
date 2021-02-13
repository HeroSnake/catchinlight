<?php // pour la page maître
$pageName = basename(__FILE__);
$titre_page = "Accueil";
$meta_description = "Maxime Brisson - Photographe amateur";
require_once "corePage.php";

//Récupérer pages
$query_pages = $bdd->prepare("SELECT * FROM pages");
$query_pages->execute();
?>
<div class="container">
    <?php while ($row = $query_pages->fetch(\PDO::FETCH_ASSOC)) { 
            if($row['visible'] == 1){?>
                <div class="col-md-11 mx-auto p-0 mb-4 section_main">                
                    <a href="<?= $row['titre_lien'] ?>">
                        <div class="hovereffect1 center-block">
                            <img class="img-responsive centerImage" src="<?= $row['image'] ?>" alt="">
                            <h2 class="section_title"><?= strtoupper($row['nom']) ?></h2>
                            <div class="overlay align-items-center">
                                <h2 class="textMenu my-auto"><?= strtoupper($row['nom']) ?></h2>
                            </div>
                        </div>
                    </a>
                </div>
    <?php   }
        } ?>
</div>

<?php
require_once "endPage.php";
?>

