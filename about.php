<?php // pour la page maître
$pageName = basename(__FILE__);
$titre_page = "À propos";
$meta_description = "À propos de Maxime Brisson - Description";
require_once "corePage.php";
?>
<div class="accueil">
    <div class="containpic">
        <div class="photoContainer">
            <img class="picMax" src="img/accueil/max_pic.jpg" alt="picture_profil">
        </div>
    </div>
    <div class="descriptionContainer">
        <p>Je m'appelle Maxime et je suis photographe amateur. Diplômé d'une Licence d'art du Spectacle
            à Grenoble en 2019 je me lance dans la production multimédia.
            Passionné de photographie depuis 2016, je vous propose de me suivre dans mon périple.
            Tout a commencé par des paysages et quelques expérimentations pour parvenir à comprendre
            et à m'approprier cet art. Le portrait s'est ainsi rapidement imposé à moi mais je reste
            évidemment ouvert à toutes sortes de projets, avide de découvertes et de rencontres.</p>
        <p>Bon visionnage,</p>
        <p class="signature">Catchin' Light</p>
    </div>
</div>
<?php
require_once "endPage.php";
?>