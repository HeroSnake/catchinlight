<?php // pour la page maître
require_once "carousel.php";

?>
<div class="container">
    <div class="row m-0 conteneurMenu">
        <?php while ($row = $sth->fetch(\PDO::FETCH_ASSOC)){
            buildMenuBlock($row['nom_gallery'], $row['lien'], $row['titre'], $row['description']);
        }?>
    </div>
</div>