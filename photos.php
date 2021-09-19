<?php // pour la page maître
$titre_page = "Photos";
$meta_description = "Liste des galleries d'images";
require_once "corePage.php";
require_once "./controllers/block_builder.php";
$sth = $bdd->prepare('SELECT * FROM galleries WHERE visible = 1 AND sub_cat = 0');
$sth->execute();
?>
<?php
if (!$is_gallery) {
    require_once "carousel.php";
}
?>
<div class="container">
    <div class="row m-0 conteneurMenu">
        <?php while ($row = $sth->fetch(\PDO::FETCH_ASSOC)){
            buildMenuBlock($row['nom_gallery'], $row['lien'], $row['titre'], $row['description']);
        }?>
    </div>
</div>
<?php
require_once "endPage.php";
?>