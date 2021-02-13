<?php
require_once 'corePage.php';
$id_image; $likes;
$sth = $bdd->prepare("SELECT * FROM image WHERE gallery_id = $id_gallery ORDER BY date_add DESC");
$sth->execute();
$images = $sth->fetchAll(\PDO::FETCH_ASSOC);
?>
<section id="photos">
    <?php
    foreach($images as $image){
        $name = $image["id"] . "." . $image["extension"];
        $liked = false;
        if(isset($_COOKIE[$image["id"]])){
            $liked = true;
        }?>
        <a class="change-icon" id="<?=$image["id"]?>" name="<?=$id_gallery?>">
            <i class="far fa-heart fa-lg" <?php if($liked){?> style="display: none;" <?php }?>></i>
            <i class="fas fa-heart fa-lg pulse text-danger" <?php if(!$liked){?> style="display: none;" <?php }?>></i>
        </a>
        <span class="like-text"><?=$image["likes"]?></span>
        <a class="lightbox" href="img/portraits/<?=$name?>.">
            <img src="img/portraits/<?=$name?>" alt="img_gallery">
        </a>
    <?php } ?>
</section>
<?php require_once "endPage.php";