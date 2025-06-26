<?php
    session_start();
    require_once "connection.php";
    if (!isset($_SESSION["username"]))
    {
        header("location:login.php");
        exit;
    }
        $requête="SELECT * FROM etablissements";
        $stmt=$connection->query($requête);
        $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
    <?php require_once "_header.php" ?>
<head>
    <link rel="stylesheet" href="Css/style5.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <h2>Trouvez l'école qui vous correspond</h2>
            <p>Une plateforme intelligente pour recommander les meilleures écoles selon votre profil et vos ambitions.</p>
            <form action="filtre.php">
                <button type="submit">Découvir</button>
            </form>
        </div>

        <div class="ecoles">
            <h2>Quelques écoles populaires</h2>
            <div class="ecole-list">
                <div class="ecole">
                    <h3>ECE Paris</h3>
                    <p>École d'ingénieurs spécialisée dans la technologie numérique, l'informatique et l'innovation.</p>
                </div>
                
                <div class="ecole">
                    <h3>EPITA</h3>
                    <p>École de premier plan en informatique et ingénierie, reconnue pour son expertise en IT, cybersécurité et intelligence artificielle.</p>
                </div>

                <div class="ecole">
                    <h3>INSEAD</h3>
                    <p>École de commerce globale avec des campus internationaux, célèbre pour ses programmes MBA diversifiés.</p>
                </div>
                
                <div class="ecole">
                    <h3>INSA Lyon</h3>
                    <p>Une des plus grandes écoles d'ingénieurs de France, offrant un programme d'informatique complet avec un fort accent sur la recherche.</p>
                </div>
            </div>

        </div>
        <div class="remplir"></div>
    </div>

<footer>
    <p>&copy; 2025 EduConseil. Tous droits réservés.</p>
</footer>
</body>
</html>