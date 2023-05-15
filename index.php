<?php
    session_start();

    //Liste des produits
    $produits = [
        [   "nom" => "Produit 1",
            "description" => "Description produit 1",
            "prix" => 19.99,
             "image" => "https://picsum.photos/id/10/300/200"],
        [   "nom" => "Produit 2",
            "description" => "Description produit 2",
            "prix" => 29.99,
            "image" => "https://picsum.photos/id/20/300/200"],
        [   "nom" => "Produit 3",
            "description" => "Description produit 3",
            "prix" => 39.99,
            "image" => "https://picsum.photos/id/30/300/200"],
        [   "nom" => "Produit 4",
            "description" => "Description produit 4",
            "prix" => 49.99,
            "image" => "https://picsum.photos/id/40/300/200"],
        [   "nom" => "Produit 5",
            "description" => "Description produit 5",
            "prix" => 59.99,
            "image" => "https://picsum.photos/id/50/300/200"],
        [   "nom" => "Produit 6",
            "description" => "Description produit 6",
            "prix" => 69.99,
            "image" => "https://picsum.photos/id/60/300/200"],
        [   "nom" => "Produit 7",
            "description" => "Description produit 7",
            "prix" => 79.99,
            "image" => "https://picsum.photos/id/70/300/200"],
        [   "nom" => "Produit 8",
            "description" => "Description produit 8",
            "prix" => 89.99,
            "image" => "https://picsum.photos/id/80/300/200"]
    ];

    //Vérifier si le panier est présent ou pas dans la session
    if (!isset($_SESSION["panier"])) {
        //Création du panier dans la session
        $_SESSION["panier"] = [];
    }

    //Vérifier si le formulaire d'ajout dans le panier
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        //Récupérer le nom du produit et son prix
        $nomProduit = $_POST["nom-produit"];
        $prixProduit = $_POST["prix-produit"];
        //Tester si le produit est déjà présent dans le panier
        if (array_key_exists($nomProduit,$_SESSION["panier"])) {
            //Le produit est déjà présent
            $_SESSION["panier"][$nomProduit]["quantite"] += 1;
        } else {
            //Le produit n'est pas présent
            //Il faut créer le produit
            $produit = [
                "nom" => $nomProduit,
                "prix" => $prixProduit,
                "quantite" => 1
            ];
            //Ajout du produit dans le panier
            $_SESSION["panier"][$nomProduit] = $produit;
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
    <title>Liste produits</title>
</head>
<body>
    <div class="container">
        <div class="icone">
            <a href="panier.php"><i class="fa-solid fa-cart-shopping"></i></a>
            <div class="texte">
                <div><?php $nbProduits = 0;
                    foreach ($_SESSION["panier"] as $produit) {
                        $nbProduits += 1;
                    }
                    echo $nbProduits;
                    ?> produit(s)</div>
                <div><?php $total = 0;
                    foreach ($_SESSION["panier"] as $produit) {
                        $total += $produit["prix"]*$produit["quantite"];
                    }
                    echo $total;
                    ?> €</div>
            </div>
        </div>
        <h1>Liste des produits</h1>
        <div class="produits">
            <?php foreach ($produits as $produit) {?>
            <div class="carte">
                <img src="<?= $produit["image"]?>" alt="Image produit">
                <h2><?= $produit["nom"];
                if (array_key_exists($produit["nom"],$_SESSION["panier"])) {?>
                    <i class="fa-solid fa-circle-check"></i>
                <?php } ?></h2>
                <p class="description"><?= $produit["description"]?></p>
                <p class="prix"><?= $produit["prix"]?> €</p>
                <!-- Ajout du produit dans le panier -->
                <form method="post">
                    <input type="hidden" name="nom-produit" value="<?= $produit["nom"]?>">
                    <input type="hidden" name="prix-produit" value="<?= $produit["prix"]?>">
                    <button type="submit" class="btn-ajout-panier"><i class="fa-solid fa-cart-plus"></i></button>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>