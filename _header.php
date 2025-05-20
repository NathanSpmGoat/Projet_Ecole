<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Recommandation</title>
    <style>
        ul {
            position: absolute;
            right: 0;
            display: flex;
            list-style-type: none;
            gap:30px;
            margin-right: 15px;
        }

        nav {
            height: 50px;
            background-color: #fff;
            padding-bottom: 5px;
            position: absolute;
        }

        nav a 
        {
            text-decoration: none;
            color:rgb(0, 71, 238);
        }
    </style>
</head>
<body>
    <nav class="navbar bg-body-tertiary px-3 mb-3 text-end">
        <ul class="nav nav-pills">
            <?php if (isset($_SESSION["username"])): ?>
                <?php if ($_SESSION["email"] == "owahnathan@gmail.com"): ?>
                    <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
                <?php endif; ?>

                <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="deconnection.php">Déconnexion</a></li>
            
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="login.php">Se connecter</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Créer un compte</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</body>
</html>