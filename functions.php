<?php
    ob_start(); // Starts output buffer

    function notif(){ // Notification handler
        if(isset($_SESSION['notification'])) { // Give a notification if it is set up (in traitement.php)
            echo "<div class='notif ".$_SESSION['notificationState']."'>",
                    "<p>".$_SESSION['notification']."</p>",
                "</div>";
            unset($_SESSION['notification']); // Unset the notification so it doesnt pop up at each refresh
            unset($_SESSION['notificationState']); // Unset the notification so it doesnt pop up at each refresh
        }

    }

    // Used to display number of products in the kart
    $totalProduit = 0;
    foreach($_SESSION['products'] as $index => $product){
        $totalProduit += $product['qtt'];
    }

    $content = ob_get_clean(); // Get new informations as $content, and clean the output buffer