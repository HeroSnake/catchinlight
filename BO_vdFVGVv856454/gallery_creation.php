<?php // pour la page maître
$titre_page = "Créer une gallerie";
require_once "core_BO.php";
?>
<form class="text-center text-white" action="gallery_create.php" method="post">
    <input id="text_picker" onchange="update_text(value)" name="titre_page" type="text" placeholder="Titre de la gallerie" maxlength="15" required></input>
    <span>Nombre colonnes: </span>
    <input id="colonne" name="colonnes" type="number" placeholder="Titre de la gallerie" value="3" required></input>
    <input id="image_picker" onchange="update_picture('G')" type="file" name="image" accept="image/*" required>
    <input name="visible" type="checkbox" checked>Visible</input>
    <input id="buttonSubmit" type="submit"></input>
</form>

<div class="container conteneurMenu">
    <div class="row m-0">
        <div class="col-md-4 col-sm-6 px-1 mx-auto">
            <div class="menu hovereffect border">
                <img id="preview_img" class="img-responsive" src="" alt="img">
                <a class="overlay">
                    <div class="align-items-center info">
                        <h2 class="preview_text p-0 my-auto textMenu"></h2>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>