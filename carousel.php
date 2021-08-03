<?php // pour la page maître
$results = $bdd->prepare('SELECT * FROM galleries WHERE visible = 1 AND sub_cat = 1');
$results->execute(array("%query%"));
$galleries = [];
$i = 0;
foreach ($results as $result) {
    $galleries[$i]['gallery'] = $result;
    $images = $bdd->prepare('SELECT * FROM image WHERE gallery_id = ' . $result['id'] . ' LIMIT 7');
    $images->execute(array("%query%"));
    foreach ($images as $image) {
        $galleries[$i]['images'][] = "img/" . $result['nom_gallery'] . "/" . $image['id'] . '.' . $image['extension'];
    }
    $i++;
}
$count = $results->rowCount();
$i = 0;
?>
<div id="carousel" class="carousel slide" data-bs-ride="carousel">
    <h1 style="color: white;position: absolute;z-index: 100;left: 50%;">Portraits</h1>
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
                                    <p class="card-text"><?= $gallery['gallery']['description'] ?></p>
                                    <div class="card-image-list animate__animated">
                                        <?php foreach ($gallery['images'] as $image) { ?>
                                            <img src="<?= $image ?>" alt="mini-carousel-image">
                                        <?php } ?>
                                    </div>
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