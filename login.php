<?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        require_once "connection.php";
        $email=htmlspecialchars($_POST["email"]);
        $passwd=htmlspecialchars($_POST["password"]);

        $requête = "SELECT * FROM user_infos WHERE email = :email";
        $stmt = $connection->prepare($requête);
        $stmt->execute(
            [':email' => $email]
                      );
        $res=$stmt->fetch(PDO::FETCH_ASSOC);
        if (!$res)
        {
            header("location:login.php?error=Email non correspond");
            exit;
        }
        else
        {   
            if (password_verify($passwd,$res["password"]))
                {
                    session_start();
                    $_SESSION["username"]=$res["Username"];
                    $_SESSION["email"]=$res["Email"];
                    header("location:menu.php");
                }
            else
                {
                    header("location:login.php?error=Mot de passe incorrect&email=$email");
                    exit;
                }
        }  
    }
?>
<!DOCTYPE html>
<html lang="fr"></html>
    <?php require_once "_header.php" ?>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Css/style1.css">
</head>
<body>
    <div class="main mt-5 justify-content-center d-grid">
        <div class="container">
            <h2 class="text-center mb-4 mt-5" style="color: #fff;">Login</h2>
            <form action="" method="POST">
                <div class="mt-3">
                    <input type="email" name="email" id="email" placeholder="Email" class="rounded-2 col-3 w-100" required value="<?= isset($_GET["email"]) ? $_GET["email"] : '' ;?>"><br>
                </div>

                <div class="mt-3" >
                    <input type="password" name="password" id="password" placeholder="Mot de passe" class="rounded-2 mb-3 col-3 w-100" required><br>
                </div>

                <span style="margin-bottom: 8px;color:red;display:inline-block;font-weight: bold;">
                    <?= isset($_GET["error"]) ? $_GET["error"] : '';?>
                </span>

                <span style="margin-bottom: 8px;color:green;display:inline-block;font-weight: bold;">
                    <?= isset($_GET["success"]) ? $_GET["success"] : '' ;?>
                </span>
                <button type="submit" class="btn btn-primary d-grid w-100 col-3">Login</button><br>
            </form>
            <p style="color: #fff;">Vous n'avez pas de compte ?<a href="register.php"> Créez un compte ici</a></p>
            <hr>
    </div>
</body>
</html>