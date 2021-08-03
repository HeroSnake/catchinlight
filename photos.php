<?php // pour la page maître
$titre_page = "Photos";
$meta_description = "Liste des galleries d'images";
require_once "corePage.php";
$sth = $bdd->prepare('SELECT * FROM galleries WHERE visible = 1 AND sub_cat = 0');
$sth->execute();
?>
<div class="container">
    <div class="row m-0 conteneurMenu">
        <?php while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {?>
            <a href="<?=$row['nom_gallery']?>" class="profile-card-2 col-sm-4">
                <img src="<?=$row['lien']?>" class="img img-responsive" alt="<?=$row['nom_gallery']?>">
                <div class="profile-name centerImage"><?=$row['titre']?></div>
                <div class="profile-username"><?=$row['description']?></div>
            </a>
        <?php } ?>
    </div>
</div>
<?php
require_once "endPage.php";
?>