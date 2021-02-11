<?php // pour la page maître
$titre_page = "Vidéos";
$meta_description = "Gallerie des vidéos de Catchin'Light";
require_once "corePage.php";
$sth = $bdd->prepare('SELECT * FROM video');
$sth->execute();
$count = 0;
?>
<!-- <div class="conteneurMenu"> -->
<?php while ($row = $sth->fetch(PDO::FETCH_ASSOC)) { 
    $video_id = explode("embed/", $row['url_video']);
    $video_id = $video_id[1];
    $count++;
?>
  <!-- Grid column -->
  <div class="col-sm-6 col-md-3 my-1">
    <!--Modal: Name-->
    <div class="modal fade" id="modal<?=$count?>" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <!--Content-->
        <div class="modal-content bg-dark">
          <!--Body-->
          <div class="modal-body mb-0 p-0">
            <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
              <iframe class="embed-responsive-item" src="<?= $row['url_video']; ?>"
                allowfullscreen></iframe>
            </div>
          </div>
          <!--Footer-->
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!--/.Content-->
      </div>
    </div>
    <!--Modal: Name-->
    <img class="thumbnail_vid img-fluid z-depth-1" src="http://img.youtube.com/vi/<?=$video_id?>/hqdefault.jpg" alt="video"
    data-toggle="modal" data-target="#modal<?=$count?>">
  </div>
  <!-- Grid column -->
<?php } 
// $cle_api = 'AIzaSyDEp8unEbajtO9ENSlJTJBQtugol7ZnPto';
require_once "endPage.php"; ?>
