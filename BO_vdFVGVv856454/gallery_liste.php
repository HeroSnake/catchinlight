<?php
$titre_page = "Liste des galleries";
require_once "core_BO.php";
require_once "php_functions.php";
$query_images = $bdd->prepare("SELECT * FROM galleries");
$query_images->execute();
?>
<script type="text/javascript">
  function Supp(link) {
    if (confirm('Confirmer la suppression ?')) {
      document.location.href = link;
    }
  }
</script>
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
            <td><a href="../' . strtolower(str_to_noaccent($row['titre'])) . '" class="fas fa-link"></a></td>
            <td>' . $row['id'] . '</td>
            <td>' . $row['Nom'] . '</td>
            <td>' . $row['titre'] . '</td>
            <td>' . $row['lien'] . '</td>';
            if ($row['visible'] == 1) {
            echo '<td><i class="fas fa-eye"></i></td>';
            } else {
            echo '<td><i class="fas fa-eye-slash"></i></td>';
            }
            echo '<td class="text-right"><a href="gallery_edit?cat=' . $row['id'] . '" class="fas fa-edit"></a></td>
            <td><a href="gallery_delete?cat=' . $row['id'] . '&page=' . strtolower(str_to_noaccent($row['titre'])) . '" class="fas fa-trash-alt"></a></td>
        <tr>';
    }
    ?>
    </tbody>
</table>