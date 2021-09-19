<?php // pour la page maître
require_once './controllers/phone_detection.php';
$results = $bdd->prepare('SELECT * FROM galleries WHERE visible = 1 AND sub_cat = 1 ORDER BY id DESC');
$results->execute(array("%query%"));
$galleries = [];
$i = 0;
foreach ($results as $result) {
    $galleries[$i]['gallery'] = $result;
    if(!$isMobile){
        $images = $bdd->prepare('SELECT * FROM image WHERE gallery_id = ' . $result['id'] . ' LIMIT 3');
        $images->execute(array("%query%"));
        foreach ($images as $image) {
            $galleries[$i]['images'][] = "img/gallery/" . $image['id'] . '.' . $image['extension'];
        }
    }
    $i++;
}
$count = $results->rowCount();
$i = 0;
?>
<div id="carousel" class="carousel slide" data-bs-ride="carousel">
    <h1 class="title-portrait">Portraits</h1>
    <div class="carousel-inner">
        <?php foreach ($galleries as $gallery) { ?>
            <div class="carousel-item <?php if ($i == 0) echo "active"; ?>">
                <a href="<?= $gallery['gallery']['nom_gallery'] ?>">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-lg-4 col-md-6">
                                <img class="carousel_img img-responsive" src="<?= $gallery['gallery']['lien']; ?>" alt="<?= $gallery['gallery']['nom_gallery']; ?>">
                            </div>
                            <div class="col-lg-8 col-md-6">
                                <div class="card-body no-padding">
                                    <h5 class="card-title"><?= $gallery['gallery']['titre'] ?></h5>
                                    <?php if (!$isMobile) { ?>
                                        <p class="card-text"><?= $gallery['gallery']['description'] ?></p>
                                        <div class="card-image-list animate__animated">
                                            <?php foreach ($gallery['images'] as $image) { ?>
                                                <img src="<?= $image ?>" alt="mini-carousel-image">
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php $i++;
        } ?>
    </div>
    <?php if ($count > 1) { ?>
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