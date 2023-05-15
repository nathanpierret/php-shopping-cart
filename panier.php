<?php
    session_start();

    if (!isset($_SESSION["panier"])) {
        //Création du panier dans la session
        $_SESSION["panier"] = [];
    }

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        if (isset($_POST["btn-modifier"])) {
            $_SESSION["panier"][$_POST["nom-produit"]]["quantite"] = $_POST["quantite"];
        } else if (isset($_POST["btn-supprimer"])) {
            unset($_SESSION["panier"][$_POST["nom-produit"]]);
        } else if (isset($_POST["btn-vider"])) {
            $_SESSION["panier"] = [];
        } else if (isset($_POST["btn-envoi"])) {
            echo "Commande envoyée";
            $_SESSION["panier"] = [];
            header("Location: index.php");
        }
    }
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
          integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <title>Panier</title>
</head>
<body>
    <div class="container">
        <h1>Votre panier</h1>
        <table class="Table">
            <thead>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="3" class="total">Total</td>
                <td class="prix-total"><?php $total = 0;
                    foreach ($_SESSION["panier"] as $produit) {
                    $total += $produit["prix"]*$produit["quantite"];
                    }
                    echo $total;
                    ?> €</td>
                <td>
                    <form method="post" class="Suppr">
                        <input type="hidden" name="type-form" value="Vider">
                        <input type="submit" name="btn-vider" value="Vider le panier">
                    </form>
                </td>
            </tr>
            </tfoot>
            <tbody>
            <?php foreach ($_SESSION["panier"] as $produit) {?>
            <tr>
                <td><?= $produit["nom"]?></td>
                <td><?= $produit["prix"]?> €</td>
                <td class="td3">
                    <form method="post">
                        <input type="hidden" name="nom-produit" value="<?= $produit["nom"]?>">
                        <input type="number" name="quantite" min="1" value="<?= $produit["quantite"]?>">
                        <input type="submit" name="btn-modifier" value="Modifier">
                    </form>
                </td>
                <td><?= $produit["prix"]*$produit["quantite"]?> €</td>
                <td>
                    <form method="post" class="Suppr">
                        <input type="hidden" name="nom-produit" value="<?= $produit["nom"]?>">
                        <input type="submit" name="btn-supprimer" value="Supprimer">
                    </form>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="Boutons">
            <a href="index.php" class="Bouton">Continuer mes achats</a>
            <form method="post">
                <input type="submit" name="btn-envoi" value="Passer ma commande" class="Bouton">
            </form>
        </div>
    </div>
</body>
</html>