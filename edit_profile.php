<?php
    session_start();
    require_once "connection.php";
    if (!isset($_SESSION["username"]))
    {
        header("location:login.php");
        exit;
    }

    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(isset($_POST["edit_profile"]))
        {
            $username=strtolower(htmlspecialchars($_POST["username"]));
            $email=strtolower(htmlspecialchars($_POST["email"]));
            $pwd=password_hash($_POST["pwd"],PASSWORD_DEFAULT) ?? '' ;
            $date = date('Y-m-d H:i:s');

            if(!empty($_POST["pwd"]))
            {
                $requête="UPDATE user_infos SET Username=:username, Email=:email,Updated_at=:date password=:pwd WHERE id=:id";
                $stmt=$connection->prepare($requête);
                $stmt->execute([
                    "username"=>$username, "email"=>$email, "pwd"=>$pwd, "id"=>$_SESSION["user_id"],"date"=>$date
                ]);
            }
            else
            {
                $username=htmlspecialchars(htmlspecialchars($_POST["username"]));
                $email=htmlspecialchars(htmlspecialchars($_POST["email"]));
                $requête="UPDATE user_infos SET Username=:username, Email=:email , Updated_at=:date WHERE id=:id";
                $stmt=$connection->prepare($requête);
                $stmt->execute([
                    "username"=>$username, 
                    "email"=>$email, 
                    "id"=>$_SESSION["user_id"],
                    "date" => $date
                ]);
            }
            $_SESSION["username"]=$username;
            $_SESSION["email"]=$email;
            header("location:profile.php");
            exit;
        }
    }
?>
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
            <h4 class="fw-semibold mt-4 text-center fs-3">Modifier mon profil</h4>
            <form action="" method="post">
                <div class="main">
                    <div class="username">
                        <label for="username" style="color:#d1d1d1; font-weight: 600;font-size:12px">Nom d'utilisateur</label>
                        <input type="username" name="username" id="username" value="<?= $_SESSION["username"] ?>">
                    </div>

                    <div class="email">
                        <label for="email" style="color:#d1d1d1; font-weight: 600;font-size:12px">Adresse email</label>
                        <input type="email" name="email" id="email" value="<?= $_SESSION["email"] ?>">
                    </div>
                        
                    <div class="password">
                        <label for="pwd" style="color:#d1d1d1; font-weight: 600;margin-right:32px;font-size:12px">Mot de passe <span style="color: #aaaaaa;font-size:12px">(laisser vide pour ne pas changer)</span></label>
                        <div class="pwd-check d-flex flex-row gap-3">
                            <input type="password" name="pwd" id="pwd" class="fs-5" placeholder="............">
                            <input type="checkbox" id="d-passwd" class="form-check checkbox">
                        </div>
                    </div>

                        <button class="button" name="edit_profile">Modifier mon profil</button>
                </form>
            </div>
        </div>
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