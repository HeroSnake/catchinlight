<?php // pour la page maître

if(isset($_GET['mailsent']) && $_GET['mailsent'] == 1){ ?>
    <div class="alert alert-success mx-auto text-center" role="alert">
        <h4 class="alert-heading">Bravo !</h4>
        <p class="alert-success">Votre message sera pris en compte très prochainement !</p>
        <hr>
        <p class="mb-0 alert-success">N'hésitez pas à visiter les <a class="alert-success link font-weight-bold" href="photos">Galleries de photos</a></p>
    </div>
<?php
}
?>
