<?php
$titre_page = "Paysages";
$meta_description = "Gallerie d'images";
$css_gallery = '<link rel="stylesheet" href="css/grid_img_3.css">';
require_once "corePage.php";
$images = [];
foreach (new DirectoryIterator(__DIR__ . "/img/paysages") as $file) {
    $extension = mime_content_type("img/paysages/".$file);
    if (strpos($extension,"image/") !== false) {
        array_push($images, $file->getFilename());
    }
}
sort($images);
?>
<section id="photos">
    <?php
    foreach($images as $image){?>
        <a class="lightbox" href="img/paysages/<?=$image?>">
            <img src="img/paysages/<?=$image?>" alt="img_gallery">
        </a>
    <?php } ?>
</section>
<?php require_once "endPage.php";