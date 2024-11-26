<?php
    session_start(); // Starts new session or continue existing one


    var_dump($_FILES['file']);

    function updateTotal($productIndex) { // function to update total price of product
        $_SESSION['products'][$productIndex]['total'] = $_SESSION['products'][$productIndex]['qtt']*$_SESSION['products'][$productIndex]['price'];
        if($_SESSION['products'][$productIndex]['qtt'] == 0){ // If it's the last of the product, delete it
            unset($_SESSION['products'][$_GET['id']]);
            $_SESSION['notification'] = 'Cet article a été supprimés.';
            $_SESSION['notificationState'] = 'good';
        }
    }

    function headerAndExit(){ // DRY function
        header('location: recap.php');
        exit(); 
    }

    if(isset($_GET['action'])){ // If $_GET is set (see url / ie if the user used some forms)

        switch($_GET['action']){ // switches to act accordingly depending on the submit pressed
            case "add" :
                if(isset($_POST['submit'])){ // If $_POST submit is set (ie if the user used the form from index.php)

                    // Sanitize inputs
                    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
                    $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);

                    // Sanitize img
                    if(isset($_FILES['file'])){
                        $tmpImgName = $_FILES['file']['tmp_name']; // Get relevant data
                        $imgName = $_FILES['file']['name'];
                        $imgSize = $_FILES['file']['size'];
                        $imgError = $_FILES['file']['error'];

                        $tabExtension = explode('.', $imgName); // explode file name
                        $extension = strtolower(end($tabExtension)); // get last element (the extension)

                        $authorisedExt = ['jpg', 'jpeg', 'png'];
                        $maxSize = 400000;

                        if(in_array($extension, $authorisedExt) && $imgSize <= $maxSize && $imgError == 0){

                            $uniqueName = uniqid('', true);
                            $imgUniqueName = $uniqueName.'.'.$extension;

                            move_uploaded_file($tmpImgName, './upload/'.$imgUniqueName);
                            $img = './upload/'.$imgUniqueName;

                        } else {
                            $_SESSION['notification'] = 'Votre image ne correspond pas à nos normes';
                            $_SESSION['notificationState'] = 'bad';
                        }
                    }
            
                    if ($name && $price && $qtt && $img){ // if the inputs are goods
            
                        $product = [ // set up the product array
                            "name" => $name,
                            "img" => $img,
                            "price" => $price,
                            "qtt" => $qtt,
                            "total" => $price*$qtt
                        ];

                        $_SESSION['products'][] = $product; // push the product in the $_SESSION
                        $_SESSION['notification'] = 'Article ajouté avec succès.'; // create a notification (called in index.php)
                        $_SESSION['notificationState'] = 'good';
                    } else {
                        $_SESSION['notification'] = "Votre article n'a pas pu être ajouté.";
                        $_SESSION['notificationState'] = 'bad';
                    }
                }
                header("location:index.php");
                exit();

            case "delete" :
                if(isset($_GET['id']) && is_numeric($_GET['id']) && in_array($_SESSION['products'][$_GET['id']], $_SESSION['products'])){ // Check if $_GET id is set, and if it's a number
                    unset($_SESSION['products'][$_GET['id']]); // unset the related product
                    $_SESSION['notification'] = 'Article supprimé avec succès.'; // create a notification (called in recap.php)
                    $_SESSION['notificationState'] = 'good';
                } else {
                    $_SESSION['notification'] = 'Une erreur est survenue.'; // create a notification (called in recap.php)
                    $_SESSION['notificationState'] = 'bad';
                }
                headerAndExit(); // head to recap.php and exit the if

            case "clear" :
                $_SESSION['products'] = []; // Set $_SESSION products as empty array
                $_SESSION['notification'] = 'Tous les articles ont été supprimés.';
                $_SESSION['notificationState'] = 'good';
                headerAndExit(); 

            case "down-qtt" :
                if(isset($_GET['id']) && is_numeric($_GET['id']) && in_array($_SESSION['products'][$_GET['id']], $_SESSION['products'])) {
                    $_SESSION['products'][$_GET['id']]['qtt'] -= 1; // -1 to the related product quantity
                    updateTotal($_GET['id']);
                    
                }
                headerAndExit();

            case "up-qtt" :
                if(isset($_GET['id']) && is_numeric($_GET['id']) && in_array($_SESSION['products'][$_GET['id']], $_SESSION['products'])) {
                    $_SESSION['products'][$_GET['id']]['qtt'] += 1; // +1 to the related product quantity
                    updateTotal($_GET['id']);
                }
                headerAndExit();
        }
    }

    header("location:index.php"); // if getting here (ie not got out with a GET action) go to index.php
