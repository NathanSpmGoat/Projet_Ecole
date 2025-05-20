
<!DOCTYPE html>
<html lang="fr">
    <?php require_once "_header.php" ?>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/style3.css">
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="header">
                <img src="https://i.pravatar.cc/150?img=12" alt="Picture Profile" class="pp" width="100" height="100">
                <div class="infos">
                    <h2 style="font-weight: 600;color:#f0f0f0;">Nathan</h2>
                    <p style="color:#ccc;font-size:13px">Membre depuis janvier 2023</p>
                </div>
            </div>
            <hr style="margin-left:26px;margin-right:26px;background-color:grey;height:2px">

            <div class="main">
                <div class="username">
                    <p>Nom d'utilisateur</p>
                    <p>Nathan</p>
                </div>

                <div class="email">
                    <p>Email</p>
                    <p>owahnathan@gmail.com</p>
                </div>

                <div class="password">
                    <p>Mot de passe</p>
                    <p style="font-size: 22px;" class="pwd">............</p>
                </div>
                <form action="edit_profile.php" method="post">
                    <button class="button" name="edit_profile">Modifier mon profil</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>