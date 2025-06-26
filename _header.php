<?php 
if (session_status() == PHP_SESSION_NONE)
    session_start();

$current = basename($_SERVER['PHP_SELF']);
?>
<head>
    <title>EduConseil</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

    * {
        margin: 0;
        padding: 0px;
        box-sizing: border-box;
        
    }

    
    nav {
        width: 100%;
        height: 60px;
        background-color: #1e1e1e;
        display: flex;
        align-items: center;
        padding: 10px 8px 0 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    

    ul {
        position:absolute;
        right:0;
        display: flex;
        list-style-type: none;
        gap: 12px;
        align-content: flex-end;
    }
    

    li {
        margin: 0;
        padding: 0;
    }

    .liens {
        text-decoration: none;
        color: #ccc;
        padding: 8px 20px;
        border-radius: 4px;
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
        transition: background-color 0.2s, color 0.2s;
        font-size:17px;
    }
    

    .liens:hover,
    .liens.active {
        color: #0a58ca;
    }


    .head{
        text-decoration: none;
        font-weight: 700;
        font-size:32px; 
        color:#ccc;
        padding-left :15px;
        padding-bottom:15px;
    }

    .head:hover {
        color: #0a58ca;
    }
    
    

</style>
<nav>
<a href="<?= isset($_SESSION["username"]) ? "accueil.php" : $current ?>" class="head">EduConseil</a>
    <ul>
        <?php if (isset($_SESSION["username"])): ?>
            <?php if ($_SESSION["admin"] == 1): ?>
                <li><a href="user.php" class="liens <?= $current == 'user.php' ? 'active' : '' ?>">User</a></li>
                <li><a href="<?= str_contains('villes_domaines.php',$current) ? $current : "data.php" ?>" class="liens <?= ($current == 'data.php' || $current == 'villes_domaines.php' ) ? 'active' : '' ?>">Data</a></li>
            <?php endif; ?>
            <li><a href="<?= $current=='edit_profile.php' ?'edit_profile.php':'profile.php'?>" class="liens <?= ($current == 'profile.php' || $current== 'edit_profile.php') ? 'active' : '' ?>">Profile</a></li>
            <li><a href="deconnection.php" class="liens">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="login.php" class="liens <?= $current == 'login.php' ? 'active' : '' ?>">Se connecter</a></li>
            <li><a href="register.php" class="liens <?= $current == 'register.php' ? 'active' : '' ?>">Créer un compte</a></li>
        <?php endif; ?>
    </ul>
</nav>
