<?php

require "functions.php";

if (isset($_GET['action'])) {

    switch ($_GET['action']) {


            // AJOUTER UN PRODUIT //
        case "add":
            if (isset($_POST['submit'])) {
                $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS); // empèche injection de SQL ou de HTML, supprime toutes les balises

                $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION); //FILTER_VALIDATE_FLOAT (champ "price") : validera le prix que s'il est un nombre à virgule (pas de texte ou autre…), le drapeau FILTER_FLAG_ALLOW_FRACTION est ajouté pour permettre l'utilisation du caractère "," ou "." pour la décimale.

                $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT); //ne validera la quantité que si celle-ci est un nombre entier différent de zéro (qui est considéré comme nul)

                if ($name && $price && $qtt) {

                    $product = ["name" => $name, "price" => $price, "qtt" => $qtt, "total" => $price * $qtt];

                    $_SESSION['products'][] = $product;

                    $_SESSION['Message']['succes'] = "<div class='green'>Produit ajouté au panier avec succès </div>";
                } else {
                    $_SESSION['Message']['erreur'] = "<div class='red'>Le produit n'a pas été ajouté au panier </div>";
                }
            }
            break;

            // VIDER LE PANIER //
        case "clear":

            //supprimer le tableau de produits en session
            unset($_SESSION['products']);

            // afficher le message de confirmation du panier vidé
            // $_SESSION['Message'] = "Le panier a été vidé !";

            // redirection
            header("Location: Recap.php");
            die();
            break;
    }
}

header("Location:index.php");
