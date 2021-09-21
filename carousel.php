<?php // pour la page maître
require_once './controllers/phone_detection.php';
$results = $bdd->prepare('SELECT * FROM galleries WHERE visible = 1 AND sub_cat = 1 ORDER BY id DESC');
$results->execute(array("%query%"));
$galleries = [];
foreach ($results as $result) {
    $galleries[] = $result;
}
$i = 0;
$count = $results->rowCount() / 3;
?>
<div id="carousel" class="carousel slide" data-bs-ride="carousel">   
    <div class="carousel-inner">
        <?php if ($isMobile) {
            foreach ($galleries as $gallery) { ?>
                <div class="carousel-item<?php if ($i == 0) echo " active"; ?>">
                    <?php buildMenuBlock($gallery['nom_gallery'], $gallery['lien'], $gallery['titre'], $gallery['description']);?>
                </div>
            <?php $i++; }
        } else {
            foreach (array_chunk($galleries,3) as $chunk) { ?>
            <div class="carousel-item<?php if ($i == 0) echo " active"; ?>">
                <div class="multi-items-carousel">
                    <?php foreach ($chunk as $gallery) {?>
                        <?php buildMenuBlock($gallery['nom_gallery'], $gallery['lien'], $gallery['titre'], $gallery['description']);?>
                    <?php } ?>
                </div>
            </div>
            <?php $i++;
            }
        }
        if ($count > 1) { ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        <?php } ?>
    </div>
</div>