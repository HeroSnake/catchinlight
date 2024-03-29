<?php // pour la page maître
$titre_page = "Créer une gallerie";
require_once "core_BO.php";
?>
<div class="container">
    <div class="row text-white">
        <div class="col-sm m-3">
            <form class="text-center text-white" action="../controllers/gallery_create.php" method="post" enctype="multipart/form-data">
                <h1>Création gallerie</h1>
                <div class="form-group">
                    <input id="text_picker" name="titre_page" type="text" placeholder="Titre de la gallerie" maxlength="15" required></input>
                </div>
                <div class="form-group">
                    <label for="colonnes">Nombre colonnes :</label>
                    <input id="colonne" name="colonnes" type="number" value="3" min="1" max="4" required></input>
                </div>
                <div class="form-group">
                    <label for="image">Image Menu :</label>
                    <input id="image_picker" type="file" name="image" accept="image/*" required></input>
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input type="checkbox" id="subCat" name="subCat" class="custom-control-input" checked></input>
                    <label class="custom-control-label" for="subCat">Sous-catégorie</label>
                </div>
                <div class="form-group">
                    <textarea name="description" id="description" placeholder="Description de la gallerie" cols="30"></textarea>
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input type="checkbox" id="visible" name="visible" class="custom-control-input" checked></input>
                    <label class="custom-control-label" for="visible">Page visible</label>
                </div>
                <input class="btn" id="buttonSubmit" type="submit" value="Créer" name="submit"></input>
            </form>
        </div>
    </div>
</div>