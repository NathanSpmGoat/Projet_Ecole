
<!DOCTYPE html>
<html lang="fr">
    <?php require_once "_header.php" ?>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/style4.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="header">
                <h4 style="font-weight: 600;">Modifier mon profil</h4>
                <img src="https://i.pravatar.cc/150?img=12" alt="Picture Profile" class="pp" width="100" height="100">
                <button class="change_pp">Changer la photo</button>
            </div>

            <div class="main">
                <div class="username">
                    <label for="username" style="color:#d1d1d1; font-weight: 600;font-size:12px">Nom d'utilisateur</label>
                    <input type="username" name="username" id="username">
                </div>

                <div class="email">
                    <label for="email" style="color:#d1d1d1; font-weight: 600;font-size:12px">Adresse email</label>
                    <input type="email" name="email" id="email">
                </div>
                    
                <div class="password">
                    <label for="pwd" style="color:#d1d1d1; font-weight: 600;margin-right:32px;font-size:12px">Mot de passe <span style="color: #aaaaaa;font-size:12px">(laisser vide pour ne pas changer)</span></label>
                    <input type="password" name="pwd" id="pwd" placeholder="............">
                </div>

                <form action="profile.php" method="post">
                    <button class="button" name="edit_profile">Modifier mon profil</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>