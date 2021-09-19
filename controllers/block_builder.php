<?php

function buildMenuBlock(string $nom, string $lien, string $titre,  string $description, bool $full = false) :void
{
    $col = "col-sm-4";
    if($full){
        $col = "";
    }
    echo '
    <a href="'.$nom.'" class="profile-card-2 '.$col.'">
        <img src="'.$lien.'" class="img img-responsive" alt="'.$nom.'">
        <div class="profile-name centerImage">'.$titre.'</div>
        <div class="profile-username">'.$description.'</div>
    </a>';
}