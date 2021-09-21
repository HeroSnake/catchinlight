<nav class="navbar navbar-expand-lg sticky">
    <div class="btn navbar-toggler" role="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars h2"></i>
        <p class="ml-2 d-inline h2">Catchin'Light</p>
    </div>
    <div class="collapse text-white navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a href="index" class="<?= active("index", $is_gallery) ?>">Home</a></li>
            <?php
            while ($row = $query_pages->fetch(\PDO::FETCH_ASSOC)) {
                if ($row['visible'] == 1) { ?>
                    <li class="dropdown-divider"></li>
                    <li class="nav-item dropdown">
                        <a href="<?= $row['titre_lien'] ?>" class="<?= active($row['titre_lien'], $is_gallery) ?> "><?= $row['nom'] ?></a>
                    </li>
                <?php
                }
            } ?>
        </ul>
    </div>
</nav>