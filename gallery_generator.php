<?php
require_once 'db_connection.php';
$meta_description = "Gallerie d'images";
$is_gallery = true;
$sth_gallery = $bdd->prepare("SELECT * FROM galleries WHERE id = $id_gallery");
$sth_gallery->execute();
$gallery = $sth_gallery->fetch(\PDO::FETCH_ASSOC);
$titre_page = $gallery['Nom'];
$gallery_name = $gallery['nom_gallery'];
$colonne = floor(12 / $gallery['columns']);

require_once 'corePage.php';
$sth_image = $bdd->prepare("SELECT * FROM image WHERE gallery_id = $id_gallery ORDER BY position");
$sth_image->execute();
$images = $sth_image->fetchAll(\PDO::FETCH_ASSOC);
?>
<div class="container">
    <div id="photos" class="row m-0 grid">
        <?php
        foreach($images as $image){
            $link = "img/$gallery_name/".$image["id"] . "." . $image["extension"];
            $liked = false;
            if(isset($_COOKIE[$image["id"]])){
                $liked = true;
            }?>
            <div class="col-sm-6 col-lg-<?=$colonne?> overflow-hidden grid-item">
                <a class="change-icon" id="<?=$image["id"]?>" name="<?=$id_gallery?>">
                    <i class="far fa-heart fa-lg" <?php if($liked){?> style="display: none;" <?php }?>></i>
                    <i class="fas fa-heart fa-lg pulse text-danger" <?php if(!$liked){?> style="display: none;" <?php }?>></i>
                </a>
                <span class="like-text"><?=$image["likes"]?></span>
                <a class="lightbox" href="<?=$link?>">
                    <img class="rounded" src="<?=$link?>" alt="img_gallery">
                </a> 
            </div>
        <?php } ?>
    </div>
</div>
<?php require_once "endPage.php";?>
