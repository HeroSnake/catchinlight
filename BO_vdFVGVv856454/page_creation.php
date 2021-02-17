<?php
$titre_page = "Créer un page";
require_once "core_BO.php";
?>
<div class="container">
    <div class="row text-white">
        <div class="col-sm m-3">
            <form class="text-center text-white" action="page_create.php" method="post">
                <h1>Création Page</h1>
                <div class="form-group">
                    <input id="text_picker" onchange="update_text(value)" name="titre_page" type="text" placeholder="Titre de la page" maxlength="15" required></input>
                </div>
                <div class="form-group">
                    <input id="text_picker" name="meta_desc" type="text" placeholder="Méta description" maxlength="50" required></input>
                </div>
                <div class="form-group">
                    <label for="image">Image Accueil :</label>
                    <input id="image_picker" onchange="update_picture('P')" type="file" name="image" accept="image/*" required>
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input type="checkbox" id="visible" name="visible" class="custom-control-input" checked></input>
                    <label class="custom-control-label" for="visible">Page visible</label>
                </div>
                <input  class="btn" id="buttonSubmit" type="submit" value="Créer"></input>
            </form>
        </div>
    </div>
</div>
<!-- <div class="col-md-11 mx-auto p-0 mb-4 section_main">           
    <a style="height: 300px;width: 100%;">
        <div class="hovereffect1 center-block">
            <img id="preview_img" class="img-responsive" src="" alt="">
            <h2 class="preview_text section_title m-0 w-100"></h2>
            <div class="overlay align-items-center">
                <h2 class="preview_text textMenu my-auto"></h2>
            </div>
        </div>
    </a>
</div> -->