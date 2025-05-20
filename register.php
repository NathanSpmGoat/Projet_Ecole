<?php 

        if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        require_once "connection.php";
        $user=htmlspecialchars($_POST["username"]);
        $email=htmlspecialchars($_POST["email"]);
        $passwd=password_hash(htmlspecialchars($_POST["password"]),PASSWORD_DEFAULT);

        $requête = "SELECT * FROM user_infos WHERE username = :username";
        $stmt = $connection->prepare($requête);
        $stmt->execute([':username' => $user]);

        if ($stmt->rowCount() > 0) {
            header("location:register.php?error=Ce nom d'utilisateur existe déjà !");
            exit;
        }

        $requête = "SELECT * FROM user_infos WHERE email = :email";
        $stmt = $connection->prepare($requête);
        $stmt->execute([':email' => $email]);

        if ($stmt->rowCount() > 0) {
            header("register:register.php?error=Cet email est déjà associé à un autre compte !!");
            exit;
        }

        $requête = "INSERT INTO user_infos(`username`, `email`, `password`) VALUES(:username, :email, :password)";
        $stmt = $connection->prepare($requête);
        $stmt->execute([
            ':username' => $user,
            ':email' => $email,
            ':password' => $passwd
        ]);

        header("location:login.php?success=Compte crée avec succès !");
        exit;

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
            <h2 class="text-center mb-4 mt-4" style="color: #fff;">Register</h2>
            <form action="" method="POST">
                <div class="mt-3" >
                    <input type="text" name="username" id="username" placeholder="Nom d'utilisateur" class="rounded-2 col-3 w-100" required><br>
                </div>

                <div class="mt-3">
                    <input type="email" name="email" id="email" placeholder="Email" class="rounded-2 col-3 w-100" required><br>
                </div>

                <div class="mt-3" >
                    <input type="password" name="password" id="password" placeholder="Mot de passe" class="rounded-2 mb-3 col-3 w-100" required><br>
                </div>
                <span style="margin-bottom: 8px;color:red;display:inline-block; font-weight: bold;"><?= isset($_GET["error"]) ? $_GET["error"] : '' ?></span>
                <button type="submit" class="btn btn-primary d-grid w-100 col-3">Register</button><br>
            </form>
            <p style="color: #fff;">Vous avez déja un compte ?<a href="login.php"> Connectez-vous ici</a></p>
            <hr>
        </div>
    </div>
</body>
</html>