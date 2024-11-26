<?php
    session_start(); // Starts new session or continue existing one
    ob_start(); // Starts output buffer

    $title = "Ajouter un produit"; // set the title variable (used in template)
    require_once "functions.php";
?>
    
    <form action="traitement.php?action=add" method="post" enctype="multipart/form-data"> <!-- Post method -> pass variables into $_POST, with the corresponding input names -->
        <p>
            <label for="name">Nom du produit :</label>
                <input type="text" name="name" required>
            </label>
        </p>
        <p>
            <label for="price">Prix du produit :</label>
                <input type="text" step="any" name="price" required>
        </p>
        <p>
            <label for="qtt">Quantité désirée :</label>
                <input type="number" name="qtt" value="1" min="1" required>
        </p>
        <p>
            <label for="file">Image :</label>
                <input type="file" name="file" required>
        </p>
        <p>
            <input type="submit" name="submit" value="Ajouter le produit">
        </p>
    </form>

    <?= notif(); ?>

<?php
    $content = ob_get_clean(); // Get new informations as $content, and clean the output buffer
    require_once "template.php"; // Loads template.php, (which will in turn use $content to display this page content)
?>