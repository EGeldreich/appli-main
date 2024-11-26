<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="style.css" rel="stylesheet" />

    <title><?=$title?></title>
</head>
<?php
    // // Used to display number of products in the kart
    // $totalProduit = 0;
    // foreach($_SESSION['products'] as $index => $product){
    //     $totalProduit += $product['qtt'];
    // }
?>
<body>
   <nav>
        <a href="index.php">Ajouter</a>
        <a href="recap.php">Panier (<?= $totalProduit ?>)</a>
   </nav>
   <?="<h1>".$title."</h1>";?>
   <div id="wrapper">
        <?= $content ?> <!-- $content is given by the output buffer get (ob_get_clean) in index.php or recap.php -->
   </div>
</body>
</html>