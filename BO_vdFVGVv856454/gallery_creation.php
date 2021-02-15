<?php // pour la page maître
$titre_page = "Créer une gallerie";
require_once "core_BO.php";
?>
<div class="container">
    <div class="row text-white">
        <div class="col-sm m-3">
            <form class="text-center text-white" action="gallery_create.php" method="post">
                <h1>Création gallerie</h1>
                <div class="form-group">
                    <input id="text_picker" onchange="update_text(value)" name="titre_page" type="text" placeholder="Titre de la gallerie" maxlength="15" required></input>
                </div>
                <div class="form-group">
                    <label for="colonnes">Nombre colonnes :</label>
                    <input id="colonne" name="colonnes" type="number" value="3" min="2" max="5" required></input>
                </div>
                <div class="form-group">
                    <label for="image">Image Menu :</label>
                    <input id="image_picker" onchange="update_picture('G')" type="file" name="image" accept="image/*" required>
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input type="checkbox" id="visible" name="visible" class="custom-control-input" checked></input>
                    <label class="custom-control-label" for="visible">Page visible</label>
                </div>
                <input class="btn" id="buttonSubmit" type="submit" value="Créer"></input>
            </form>
        </div>
    </div>
</div>
<!-- <div class="container conteneurMenu">
    <div class="row m-0">
        <div class="col-md-4 col-sm-6 px-1 mx-auto">
            <div class="menu hovereffect border">
                <img id="preview_img" class="img-responsive" src="" alt="img">
                <a class="overlay">
                    <div class="align-items-center info">
                        <h2 id="preview_text" class="p-0 my-auto textMenu"></h2>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div> -->