<?php
$titre_page = "Liste des galleries";
$origin = "gallery";
require_once "core_BO.php";
require_once "../controllers/php_functions.php";
$query_images = $bdd->prepare("SELECT * FROM galleries");
$query_images->execute();
?>
<script src="../js/confirmation_modal.js"></script>
<table class="table table-striped table-dark table_bo">
    <thead>
        <tr>
            <th>Lien</th>
            <th>ID</th>
            <th>Titre</th>
            <th>Nom Menu</th>
            <th>Image</th>
            <th>Visible</th>
            <th>Sous-catégorie</th>
            <th class="text-center" colspan="2">Outils de gestion</th>
        </tr>
    </thead>
    <tbody>
        <?php
            while ($row = $query_images->fetch(\PDO::FETCH_ASSOC)) {
                echo
                '<tr>
                    <td><a href="../' . $row['nom_gallery'] . '" class="btn btn-default text-white fas fa-link"></a></td>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['Nom'] . '</td>
                    <td>' . $row['titre'] . '</td>
                    <td><img class="table_image" src="../'.$row['lien'].'"/></td>
                    <td class="text-center">';
                    if ($row['visible'] == 1) {
                        echo '<a class="btn btn-default fas fa-eye toggleVisibility" name="'.$row['id'].'" title="0"></a>';
                    } else {
                        echo '<a class="btn btn-default fas fa-eye-slash toggleVisibility" name="'.$row['id'].'" title="1"></a>';
                    }
                    echo '
                    </td>
                    <td class="text-center">';
                    if ($row['sub_cat'] == 1) {
                        echo '<input type="checkbox" value="" class="toggleSubCat" name="'.$row['id'].'" checked>';
                    } else {
                        echo '<input type="checkbox" value="" class="toggleSubCat" name="'.$row['id'].'">';
                    }
                    echo '
                    </td>
                    <td class="text-center">
                        <a href="gallery_edit?cat=' . $row['id'] . '" class="btn btn-default text-white fas fa-edit"></a>
                        <a class="btn btn-default hover-overlay fas fa-trash-alt text-danger btn-confirm" id="'.$row['id'].'" name="'.$row['nom_gallery'].'"></a>
                    </td>
                <tr>';
            }
        ?>
    </tbody>
</table>
<a href="gallery_creation" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter une gallerie</a>
<?php require_once 'confirmation_modal.php';