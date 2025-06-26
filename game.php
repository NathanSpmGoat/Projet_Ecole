<?php
require_once "connection.php";
session_start();
if (isset($_SESSION["username"]))
    {
        header("location:login.php");
        exit;
    }

if (isset($_POST['action'])):unset($_SESSION["page_resultat"]);endif;

if((!isset($_SESSION["bonne_reponse"]) || isset($_POST["action"]) || $_SERVER["REQUEST_METHOD"]=="GET") && !isset($_SESSION["page_resultat"])) :
    $requête="SELECT * FROM etablissements";
    $stmt=$connection->query($requête);
    $ecoles=$stmt->fetchAll(PDO::FETCH_ASSOC);

    $requête2="SELECT * FROM domaines";
    $stmt2=$connection->query($requête2);
    $domaines=$stmt2->fetchAll(PDO::FETCH_ASSOC);

    $requête1="SELECT * FROM villes";
    $stmt1=$connection->query($requête1);
    $villes=$stmt1->fetchAll(PDO::FETCH_ASSOC);

    $ecoles_random = array_rand($ecoles,4);
    $reponses_key=$ecoles_random;
    shuffle($reponses_key);
    $reponses = [];

    foreach ($reponses_key as $key) {
        $reponses[] = $ecoles[$key]['nom'];
    }

    $domaine_ecole=$domaines[$ecoles[$ecoles_random[0]]["domaine_id"]]["nom"];

    $requête3="SELECT libellé FROM indices WHERE etablissement_id = :id";
    $stmt3=$connection->prepare($requête3);
    $stmt3->execute([":id"=>$ecoles_random[0]]);
    $indices=$stmt3->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION["bonne_reponse"]=$ecoles_random[0];
    $_SESSION["ecoles"]=$ecoles;
    $_SESSION["domaines"]=$domaines;
    $_SESSION["villes"]=$villes;
endif;


// Gestion du jeu
$jeu_termine = false;
$message_succes = false; 
$message_erreur = false;
if (isset($_POST['reponse']) && ($_SERVER["REQUEST_METHOD"]=="POST"))
{
    $jeu_termine = true;
    if($_SESSION["ecoles"][$_SESSION["bonne_reponse"]]["nom"]==$_POST["reponse"])
    {
        if(isset($_SESSION['score'])):$_SESSION['score']++;else:$_SESSION['score']=1;endif;
        $_SESSION["succes"]=true;
        $message_succes = "🎉 Bravo ! <strong>{$_SESSION['ecoles'][$_SESSION['bonne_reponse']]['nom']}</strong><br>📍 {$_SESSION['villes'][$_SESSION['ecoles'][$_SESSION['bonne_reponse']]['ville_id']]['nom']} - {$_SESSION['domaines'][$_SESSION['ecoles'][$_SESSION['bonne_reponse']]['domaine_id']]['nom']}";
    }
    else
    {
        $message_erreur = "❌ Raté ! C'était : <strong>{$_SESSION['ecoles'][$_SESSION['bonne_reponse']]['nom']}</strong><br>📍 {$_SESSION['villes'][$_SESSION['ecoles'][$_SESSION['bonne_reponse']]['ville_id']]['nom']} - {$_SESSION['domaines'][$_SESSION['ecoles'][$_SESSION['bonne_reponse']]['domaine_id']]['nom']}";
        $_SESSION["succes"]=false;
    }

    if(isset($_SESSION["page_resultat"])):unset($_SESSION["page_resultat"]);else:$_SESSION["page_resultat"]=true;endif;
}
if(isset($_SESSION["page_resultat"]) && $_SERVER["REQUEST_METHOD"]=="GET"):
    $jeu_termine = true;
    if($_SESSION["succes"])
    {
        $message_succes = "🎉 Bravo ! <strong>{$_SESSION['ecoles'][$_SESSION['bonne_reponse']]['nom']}</strong><br>📍 {$_SESSION['villes'][$_SESSION['ecoles'][$_SESSION['bonne_reponse']]['ville_id']]['nom']} - {$_SESSION['domaines'][$_SESSION['ecoles'][$_SESSION['bonne_reponse']]['domaine_id']]['nom']}";
    }
    else
    {
        $message_erreur = "❌ Raté ! C'était : <strong>{$_SESSION['ecoles'][$_SESSION['bonne_reponse']]['nom']}</strong><br>📍 {$_SESSION['villes'][$_SESSION['ecoles'][$_SESSION['bonne_reponse']]['ville_id']]['nom']} - {$_SESSION['domaines'][$_SESSION['ecoles'][$_SESSION['bonne_reponse']]['domaine_id']]['nom']}";
    }
endif;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>École Mystère</title>
    <link rel="stylesheet" href="Css/style6.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏫 École Mystère</h1>
            <p>Devinez de quel établissement il s'agit !</p>
            <div class="domaines-overview">
                <h4>🎯 <?=count($_SESSION["ecoles"])?> écoles dans <?=count($_SESSION["domaines"])?> domaines</h4>
                <div class="domaines-grid">
                    <?php foreach($_SESSION["domaines"] as $dom): 
                        $nb=0;
                        foreach($_SESSION["ecoles"] as $school):
                            if($school["domaine_id"]==$dom["id"]):
                                $nb++;
                            endif;
                        endforeach;
                        ?>
                        <div class="domaine-stat"><strong><?=$dom["nom"]?></strong><br><small><?=$nb?> école<?=$nb>1?'s':''?></small></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="score">🏆 Score: <?=isset($_SESSION['score'])?$_SESSION['score']:0?></div>
        </div>

        <?php if($message_succes): ?><div class="message succes"><?=$message_succes?></div><?php endif; ?>
        <?php if($message_erreur): ?><div class="message erreur"><?=$message_erreur?></div><?php endif; ?>

        <?php if(!$jeu_termine): ?>
            <div class="domaine-badge">📚 Domaine : <?=$domaine_ecole?></div>
            <div class="indices">
                <h3>🔍 Indices mystérieux :</h3>
                <?php foreach($indices as $indice): ?><div class="indice"><?=$indice["libellé"]?></div><?php endforeach; ?>
            </div>
            <form method="POST" class="reponses">
                <h3>🎯 Quelle est cette école ?</h3>
                <?php foreach($reponses as $nb =>$rep): ?>
                    <button type="submit" name="reponse" value="<?=$rep?>" class="reponse-btn"><?=chr(65+$nb)?>. <?=$rep?></button>
                <?php endforeach; ?>
            </form>
        <?php else: ?>
            <div class="connect-cta">
                <h4>🎉 Félicitations !</h4>
                <p>Vous avez un excellent œil !</p>
                <p><strong>Connectez-vous</strong> pour découvrir plus de détails.</p>
            </div>
            <div class="actions">
                <form method="POST" style="display:inline" action="login.php">
                    <button type="submit" name="action" value="connexion" class="btn btn-primary">🔐 Se connecter</button>
                </form>
                <form method="POST" style="display:inline">
                    <button type="submit" name="action" value="nouvelle_partie" class="btn btn-secondary">🎲 Nouvelle énigme</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
