<?php // pour la page maître
$titre_page = "Photos";
$meta_description = "Liste des galleries d'images";
require_once "corePage.php";
$sth = $bdd->prepare('SELECT * FROM categorie');
$sth->execute();
?>
<div class="container conteneurMenu">
    <div class="row m-0">
        <?php while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            if ($row['visible'] == 1) { ?>
                <div class="col-md-4 col-sm-6 px-1 mx-auto">
                    <div class="menu hovereffect">
                        <img class="img-responsive" src="<?= $row['lien']; ?>" alt="<?= $row['nom_categorie']; ?>">
                        <a class="overlay" href="<?= $row['nom_categorie']; ?>">
                            <div class="align-items-center info">
                                <h2 class="p-0 my-auto textMenu"><?= $row['titre']; ?></h2>
                            </div>
                        </a>
                    </div>
                </div>
        <?php }
        }
        ?>
    </div>
</div> 
<?php
require_once "endPage.php";
?>
