<?php
$titre_page = "Portraits";
$meta_description = "Gallerie d'images";
$css_gallery = '<link rel="stylesheet" href="css/grid_img_5.css">';
require_once "corePage.php";
$images = [];
foreach (new DirectoryIterator(__DIR__ . "/img/portraits") as $file) {
    $extension = mime_content_type("img/portraits/".$file);
    if (strpos($extension,"image/") !== false) {
        array_push($images, $file->getFilename());
    }
}
sort($images);
?>
<section id="photos">
    <?php
    foreach($images as $image){?>
    <div>
        <a class="change-icon" onclick="toggleLike(this)">
            <i class="fapulse far fa-heart fa-lg"></i>
            <i class="fapulse fas fa-heart fa-lg pulse text-danger"></i>
        </a>
        <a class="lightbox" href="img/portraits/<?=$image?>">
            <img src="img/portraits/<?=$image?>" alt="img_gallery">
        </a>
    </div>
    <?php } ?>
</section>
<?php require_once "endPage.php";