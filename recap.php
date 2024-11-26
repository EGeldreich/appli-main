<?php
    session_start(); // Starts new session or continue existing one
    ob_start(); // Starts output buffer

    require_once "functions.php";
    $title = "Panier"; // set the title variable (used in template)

    if(!isset($_SESSION['products']) || empty($_SESSION['products'])){ // if $_SESSION['products'] doesnt exist or is empty
        echo "<p>Aucun produit en session...</p>"; // display ...
    } else { // if not (at least one product)
        echo "<table>", // create a table
                "<thead>",
                    "<tr>",
                        "<th>#</th>",
                        "<th>Image</th>",
                        "<th>Nom</th>",
                        "<th>Prix</th>",
                        "<th>Quantité</th>",
                        "<th>Total</th>",
                    "</tr>",
                "</thead>",
                "<tbody>";
        $totalGeneral = 0; // Set grand total as 0 for starter
        foreach($_SESSION['products'] as $index => $product){
            echo "<tr>", // create a row with according elements
                    "<td>".$index."</td>",
                    "<td><img class='product-img' src='".$product['img']."'></td>",
                    "<td>".$product['name']."</td>",
                    "<td>".number_format($product['price'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                    "<td>",
                        "<a href='traitement.php?action=down-qtt&id=".$index."'><button>-</button></a>" // use correct href for usable $_GET data in traitement.php
                        .$product['qtt'].
                        "<a href='traitement.php?action=up-qtt&id=".$index."'><button>+</button></a>",
                    "</td>",
                    "<td>".number_format($product['total'], 2, ",", "&nbsp;")."&nbsp;€</td>",
                    "<td>",
                        "<a href='traitement.php?action=delete&id=".$index."'><button>Supprimer</button></a>",
                    "</td>",
                "</tr>";
            $totalGeneral += $product['total']; // update grand total
        }
        echo "<tr>",
                "<td colspan=5>Total général : </td>",
                "<td><strong>".number_format($totalGeneral, 2, ",", "&nbsp;")."&nbsp;€</strong></td>",
            "</tr>",
            "<tr>",
                "<td colspan=7>",
                    "<a href='traitement.php?action=clear'><button>Tout supprimer</button></a>",
                "</td>",
            "</tr>",
            "</tbody>",
            "</table>";
    }

    notif();
    $content = ob_get_clean(); // Get new informations as $content, and clean the output buffer
    require_once "template.php"; // Loads template.php, (which will in turn use $content to display this page content)
?>
