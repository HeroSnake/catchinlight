<nav class="navbar navbar-expand-lg sticky">
    <div class="btn navbar-toggler" role="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars h2"></i>
        <p class="ml-2 d-inline h2">Catchin'Light</p>
    </div>
    <div class="collapse text-white navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a href="index" class="<?= active("index") ?>">Home</a></li>
            <?php
            while ($row = $query_pages->fetch(\PDO::FETCH_ASSOC)) {
                if ($row['visible'] == 1) { ?>
                    <li class="dropdown-divider"></li>
                    <?php
                    if ($row['nom'] == "Services") { ?>
                        <li class="nav-item dropdown">
                            <a href="<?= $row['titre_lien'] ?>" class="nav-link <?= active($row['titre_lien']) ?> pointer"><?= $row['nom'] ?></a>
                        </li>
                    <?php
                    } else { ?>
                        <li class="nav-item">
                            <a href="<?= $row['titre_lien'] ?>" class="<?= active($row['titre_lien']) ?>"><?= $row['nom'] ?></a>
                        </li>
            <?php
                    }
                }
            } ?>
        </ul>
    </div>
</nav>