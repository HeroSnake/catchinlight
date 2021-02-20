<?php
$titre_page = "Liste des pages";
$origin = "page";
require_once "core_BO.php";
require_once "../controllers/php_functions.php";
$query_images = $bdd->prepare("SELECT * FROM pages");
$query_images->execute();
?>
<script src="../js/confirmation_modal.js"></script>
<table class="table table-striped table-dark">
    <thead>
        <tr>
            <th>Lien</th>
            <th>ID</th>
            <th>Titre</th>
            <th>Nom Menu</th>
            <th>Image</th>
            <th style="width:1px;">Visible</th>
            <th class="text-center" colspan="2">Outils de gestion</th>
        </tr>
    </thead>
    <tbody>
        <?php
            while ($row = $query_images->fetch(\PDO::FETCH_ASSOC)) {
                echo
                '<tr>
                    <td><a href="../' . $row['titre_lien'] . '" class="btn btn-default text-white fas fa-link"></a></td>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['nom'] . '</td>
                    <td>' . strtoupper($row['nom']) . '</td>
                    <td>' . $row['image'] . '</td>';
                    if ($row['visible'] == 1) {
                        echo '<td><i class="fas fa-eye"></i></td>';
                    } else {
                        echo '<td><i class="fas fa-eye-slash"></i></td>';
                    }
                    echo '<td class="text-center">
                        <a href="page_edit?cat=' . $row['id'] . '" class="btn btn-default text-white fas fa-edit"></a>
                        <a class="btn btn-default hover-overlay fas fa-trash-alt text-danger btn-confirm" id="'.$row['id'].'" name="'.$row['titre_lien'].'"></a>
                    </td>
                <tr>';
            }
        ?>
    </tbody>
</table>
<?php require_once 'confirmation_modal.php';