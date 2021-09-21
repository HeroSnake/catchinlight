<?php // pour la page maître
$pageName = basename(__FILE__);
$titre_page = "À propos";
$meta_description = "À propos de Maxime Brisson - Description";
require_once "corePage.php";
?>
<style>
    .fonts {
        font-size: 14px
    }

    .info {
        color: white;
    }

    .photoContainer {
        width: 220px;
        height: 220px;
        overflow: hidden;
        border-radius: 50%;
        margin-right: 50px;
        margin: auto;
    }

    .picMax {
        width: auto;
        height: 100%;
        margin-left: -50px;
    }

    .hori-timeline .events .event-list {
        display: block;
        position: relative;
        text-align: center;
        margin-right: 0;
    }

    .hori-timeline .events .event-list .event-date {
        position: absolute;
        top: -30px;
        font-size: 20px;
        left: 0;
        right: 0;
        width: 75px;
        margin: 0 auto;
        border-radius: 4px;
        padding: 2px 4px;
    }

    .flex-center {
        display: block;
        align-items: unset;
    }

    @media (min-width: 1140px) {
        .hori-timeline .events .event-list {
            display: inline-block;
            width: 24%;
        }

        .hori-timeline .events .event-list .event-date {
            top: -34px;
            font-size: 23px;
        }

        .flex-center {
            display: flex;
            align-items: center;
        }
    }

    .timeline {
        border: none;
        margin: 30px 0;
    }

    .desc {
        font-size: 10px;
    }

    hr {
        height: 3px;
    }
</style>
<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="text-center">
                <div class="photoContainer">
                    <img class="picMax" src="img/accueil/max_pic.jpg" alt="picture_profil">
                </div>
            </div>
            <div class="info text-center mt-3"> <span class="bg-secondary p-1 px-4 rounded">Grenoble</span>
                <h5 class="mt-2 mb-0">Maxime Brisson</h5>
                <span>Photographe</span>
                <div class="px-4 mt-4">
                    <p class="fonts">Je m'appelle Maxime et je suis photographe amateur. Diplômé d'une Licence d'art du Spectacle
                        à Grenoble en 2019 je me lance dans la production multimédia.
                        Passionné de photographie depuis 2016, je vous propose de me suivre dans mon périple.
                        Tout a commencé par des paysages et quelques expérimentations pour parvenir à comprendre
                        et à m'approprier cet art. Le portrait s'est ainsi rapidement imposé à moi mais je reste
                        évidemment ouvert à toutes sortes de projets, avide de découvertes et de rencontres.</p>
                    <p>Bon visionnage,</p>
                    <p class="signature">Catchin' Light</p>
                </div>
                <a href="contact" class="btn btn-primary">Contact</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid text-white">
    <div class="row">
        <div class="col-lg-12">
            <hr>
            <div class="timeline">
                <div class="timeline-body">
                    <div class="hori-timeline" dir="ltr">
                        <ul class="list-inline events flex-center">
                            <?php while ($row = $query_services->fetch(\PDO::FETCH_ASSOC)) { ?>
                                <li class="list-inline-item event-list mb-5">
                                    <div class="px-4">
                                        <div class="event-date">
                                            <i class="fas <?= $row['icon'] ?>"></i>
                                        </div>
                                        <h5><?= $row['titre'] ?></h5>
                                        <p class="desc"><?= $row['description'] ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once "endPage.php";
?>