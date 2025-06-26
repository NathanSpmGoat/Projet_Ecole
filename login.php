<?php 
    session_start();
    if (isset($_SESSION["username"]))
    {
        header("location:accueil.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (isset($_POST["submit"]))
        {
            require_once "connection.php";
            $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
            $passwd=$_POST["password"];

            $requête = "SELECT * FROM user_infos WHERE Email = :email";
            $stmt = $connection->prepare($requête);
            $stmt->execute(
                [':email' => strtolower($email)]
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
                        $_SESSION["username"]=$res["Username"];
                        $_SESSION["email"]=$res["Email"];
                        $_SESSION["admin"]=$res["Admin"];
                        $token=bin2hex(random_bytes(32));
                        $_SESSION["user_id"]=$res["id"];
                        $cookiesvalues= $_SESSION["user_id"].":".$token;
                        $expire_date=time() + 3600 * 24 * 365;
                        $expire_date_forever = time() + 3600 * 24 * 365 * 100;
                        $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
                        setcookie("remember_me", $cookiesvalues, [
                            'expires' => $expire_date,
                            'path' => '/',
                            'secure' => $secure,
                            'httponly' => true,
                            'samesite' => 'Lax'
                        ]);       
                        
                        if (!isset($_COOKIE["Already"]))
                        {
                            setcookie("Already", $cookiesvalues, [
                                'expires' => $expire_date_forever,
                                'path' => '/',
                                'secure' => $secure,
                                'httponly' => true,
                                'samesite' => 'Lax'
                            ]);
                        }
                        $requête="UPDATE user_infos SET token = :token , Permanent_token =:permanent WHERE email = :email";
                        $stmt=$connection->prepare($requête);
                        $stmt->execute(
                            [':token' => hash('sha256', $token), ':permanent' => hash('sha256', $token) ,':email' => $email]
                        );
                        header("location:accueil.php");
                    }
                else
                    {
                        header("location:login.php?error=Mot de passe incorrect&email=$email");
                        exit;
                    }
            }  
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once "_header.php" ?>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/style1.css">
</head>
<body>
    <div class="main mt-5 justify-content-center d-grid">
        <div class="container">
            <h2 class="text-center mb-4 mt-5" style="color: #fff;">Login</h2>
            <form action="" method="POST">
                <div class="mt-3">
                    <input type="email" name="email" id="email" placeholder="Email" class="rounded-2 col-3 w-100 ps-1" required value="<?= isset($_GET["email"]) ? $_GET["email"] : '' ;?>"><br>
                </div>

                <div class="mt-3 w-100">
                    <div class="pwd d-flex gap-2 w-100">
                        <input type="password" name="password" id="pwd" placeholder="Mot de passe" class="passwd rounded-2 mb-3 col-3 ps-1" required>
                        <input type="checkbox" class="checkbox form-check" id="d-passwd">
                    </div>
                </div>

                <span style="margin-bottom: 8px;color:red;display:inline-block;font-weight: bold;">
                    <?= isset($_GET["error"]) ? $_GET["error"] : '';?>
                </span>

                <span style="margin-bottom: 8px;color:green;display:inline-block;font-weight: bold;">
                    <?= isset($_GET["success"]) ? $_GET["success"] : '' ;?>
                </span>
                <button type="submit" class="btn btn-primary d-grid w-100 col-3" name="submit">Login</button><br>
            </form>
            <p style="color: #fff;">Vous n'avez pas de compte ?<a href="register.php" class="text-decoration-none"> Créez un compte ici</a></p>
            <hr>
    </div>
    <script>
        const pwd_input = document.getElementById("pwd");
        const checkbox = document.getElementById("d-passwd");

        checkbox.addEventListener("change",()=>{
            if(pwd_input.getAttribute("type")=="text")
            {
                pwd_input.setAttribute("type","password");
            }
            else
            {
                pwd_input.setAttribute("type","text");
            }
        })
    </script>
</body>
</html>