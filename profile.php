<?php
    require_once "connection.php";
    session_start();
    if (!isset($_SESSION["username"]))
    {
        header("location:login.php");
        exit;
    }

    $requête="SELECT * FROM user_infos";
    $stmt=$connection->query($requête);
    $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
    $year=str_split($res[0]["Created_at"],4)[0];
    $username=$res[0]["Username"];
    $email = $res[0]["Email"];
    $timestamp = strtotime($res[0]["Created_at"]);

    $mois_fr = [
        1 => "janvier", 2 => "février", 3 => "mars", 4 => "avril",
        5 => "mai", 6 => "juin", 7 => "juillet", 8 => "août",
        9 => "septembre", 10 => "octobre", 11 => "novembre", 12 => "décembre"
    ];

    $mois_num = (int)date("n", $timestamp); 
    $annee = date("Y", $timestamp);

    $mois_lettres = $mois_fr[$mois_num];
    
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once "_header.php";?> 
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/style3.css">
</head>
<body>
    <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
        <div class="content">
            <div class="header">
                <h2 style="font-weight: 600;color:#f0f0f0;"><?=$username?></h2>
                <p style="color:#ccc;font-size:13px">Membre depuis <?=$mois_lettres?> <?=$year?></p>
            </div>
            <hr style="margin-left:26px;margin-right:26px;background-color:grey;height:3px;margin-block-start:7px">
            <div class="main">
                <div class="username">
                    <p>Nom d'utilisateur</p>
                    <p><?=$username?></p>
                </div>

                <div class="email">
                    <p>Email</p>
                    <p><?=$email?></p>
                </div>

                <div class="password">
                    <p>Mot de passe</p>
                    <p style="font-size: 22px;" class="pwd mb-3">............</p>
                </div>
                <form action="edit_profile.php" class="w-100">
                    <button class="button" name="edit">Modifier mon profil</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>