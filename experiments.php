<?php
$titre_page = "Experiments";
$meta_description = "Gallerie d'images";
$css_gallery = '<link rel="stylesheet" href="css/grid_img_2.css">';
require_once "corePage.php";
$images = [];
foreach (new DirectoryIterator(__DIR__ . "/img/experiments") as $file) {
    $extension = mime_content_type("img/experiments/".$file);
    if (strpos($extension,"image/") !== false) {
        array_push($images, $file->getFilename());
    }
}
sort($images);
?>
<section id="photos">
    <?php
    foreach($images as $image){?>
        <a class="lightbox" href="img/experiments/<?=$image?>">
            <img src="img/experiments/<?=$image?>" alt="img_gallery">
        </a>
    <?php } ?>
</section>
<?php require_once "endPage.php";