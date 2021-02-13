<?php // pour la page maître
$titre_page = "Contact";
$meta_description = "Page de contact";
require_once "corePage.php";

//Récupérer clé captcha
$cle;
$query_pages = $bdd->prepare("SELECT * FROM cles");
$query_pages->execute();
$result = $query_pages->fetch(\PDO::FETCH_ASSOC);
$cle = $result['value'];

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

<section class="mb-4 text-light w-80 m-auto py-4">
    <h2 class="h1-responsive font-weight-bold text-center">Contactez Nous !</h2>
    <p class="text-center w-responsive mx-auto mb-5">Vous avez des questions ? N'hésitez pas à nous contacter directement par mail ou avec le formulaire ci-dessous.</p>
    <div class="row">
        <div class="col-md-9 mb-md-0 mb-5">
            <form id="contact-form" name="contact-form" action="mail.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <div class="md-form">
                            <input type="text" id="name" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="md-form">
                            <input type="email" id="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-md-12">
                        <div class="md-form">
                            <input type="text" id="subject" name="subject" class="form-control" placeholder="Your subject" required>
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-md-12">
                        <div class="md-form">
                            <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea" placeholder="Write something !" required></textarea>
                        </div>
                    </div>
                </div>
                <html>
                <div class="g-recaptcha  my-2" data-sitekey="<?=$cle?>"></div>
                <div class="text-center text-md-left">
                    <input class="btn btn-primary" type="submit" value="Send">
                </div>
            </form>
            <div class="status"></div>
        </div>
        <div class="col-md-3 text-center">
            <ol class="list-unstyled mb-0">
                <li>
                    <a class="link" href="mailto:catchin.light@gmail.com?subject=Demande d'informations" target="_self" data-content="catchin.light@gmail.com" data-type="mail">
                    <i class="fas fa-envelope mx-auto fa-3x"></i><br>catchin.light@gmail.com</a>
                </li>
            </ol>
        </div>
    </div>
</section>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php
require_once "endPage.php";
?>