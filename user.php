<?php
    session_start();
    require_once "connection.php";
    
    if (!isset($_SESSION["username"]))
    {
        header("location:login.php");
        exit;
    }
    elseif (!isset($_SESSION["admin"]))
    {
        header("location:index.php");
        exit;
    }
    
    $requête="SELECT * FROM user_infos";
    $stmt=$connection->query($requête);
    $res=$stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if (isset($_POST["delete"]))
        {
            $requête1="DELETE FROM user_infos WHERE id=:id_user";
            $stmt1=$connection->prepare($requête1);
            $stmt1->bindParam(":id_user",$_POST["id_user"]);
            $stmt1->execute();
            usleep(400000);
            if (strtolower($_POST["email_user"])== strtolower($_SESSION["email"]))
            {
                header("location:deconnection.php");
                exit;
            }
            header("location:user.php");
            exit;
        }
        elseif (isset($_POST["add"]))
        {
            $username=trim(htmlspecialchars($_POST["username-add"]));
            $email=trim(htmlspecialchars($_POST["email-add"]));
            $password=password_hash($_POST["password-add"],PASSWORD_DEFAULT);
            $status=$_POST["status-add"];
            $requête1="INSERT INTO user_infos (Username , Email , password, Admin) VALUES (:username , :email, :password,:status)";
            $stmt1=$connection->prepare($requête1);
            $stmt1->bindParam(":username",$username);
            $stmt1->bindParam(":email",$email);
            $stmt1->bindParam(":password",$password);
            $stmt1->bindParam(":status",$status);
            $stmt1->execute();
            usleep(400000);
            header("location:user.php");
            exit;
        }
        elseif (isset($_POST["edit"]))
        {
            $username=trim(htmlspecialchars($_POST["username-edit"]));
            $email=trim(htmlspecialchars($_POST["email-edit"]));
            $status=$_POST["status-edit"];
            $params = [];
            $requête1="UPDATE user_infos SET Username=:username , Email = :email , Admin=:status, UPDATED_AT=:id_date";
            if (!empty($_POST["password-edit"]))
            {
                $params[":password"]=password_hash($_POST["password-edit"],PASSWORD_DEFAULT);
                $requête1.=" ,password=:password";
            }
            $requête1 .=" WHERE id=:id";
            $params[":username"]=$username;
            $params[":email"]=$email;
            $params[":status"]=$status;
            $params[":id"] = $_POST["id_user"];
            $my_date= $date = date('Y-m-d H:i:s');
            $params[":id_date"]=$my_date;
            $stmt1=$connection->prepare($requête1);
            $stmt1->execute($params);
            usleep(400000);
            if (strtolower($_POST["email_user"])==strtolower($_SESSION["email"])){
                $_SESSION["username"] = $username;
                $_SESSION["email"]= $email;
                $_SESSION["admin"] = $status;
                usleep(400000);
            }
            header("location:user.php");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once "_header.php" ;?> 
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<link rel="stylesheet" href="Css/style7.css">
</head>
<body>
    <!-- Modal Add -->
<div class="modal-container-add">
        <div class="overlay-add modal-trigger-add"></div>
            <div class="my-modal-add mt-5 justify-content-center d-grid">
                <div class="container2 rounded-3">
                    <h2 class="text-center mb-4 mt-5" style="color: #fff;">Ajouter un utilisateur</h2>
                    <form action="" method="post">
                        <div class="mt-3">
                            <input type="text" name="username-add" id="username-add" placeholder="Nom d'utilisateur" class="rounded-2 col-3 w-100 ps-1" required><br>
                            <label for="username-add" id="error-username-add" class="form-label fw-bold" style="color: red;visibility: hidden;">Username déja utilisé</label>
                        </div>

                        <div class="mt-3">
                            <input type="email" name="email-add" id="email-add" placeholder="Email" class="rounded-2 col-3 w-100 ps-1" required ><br>
                            <label for="email-add" id="error-email-add" class="form-label fw-bold" style="color: red;visibility: hidden;">Email déja utilisé</label>
                        </div>

                        <div class="mt-3  d-flex justify-content-center align-items-center gap-2">
                            <input type="password" name="password-add" id="password-add" placeholder="Mot de passe" class="rounded-2 flex-grow-1 mb-3 col-3 ps-1" required>
                            <input class="checkbox form-check mb-2" type="checkbox" name="nochange" value="1" id="checkbox_add">
                        </div>

                        <div class="mt-3" >
                            <span style="color: #fff;font-size: 20px;">Status</span><br>
                            <div class="form-check" style="display: inline-block;">
                                <input class="form-check-input" type="radio" name="status-add" id="admin-add" value="1" required>
                                <label class="form-check-label" for="admin-add" style="color: #fff;font-size: 15px;">Admin</label>
                            </div>

                            <div class="form-check" style="display: inline-block;margin-left: 10px;">
                                <input class="form-check-input" type="radio" name="status-add" id="user-add" value="0" required>
                                <label class="form-check-label" for="user-add" style="color: #fff;font-size: 15px;">User</label>
                            </div>
                        </div>
                        <button type="submit" class="add btn d-grid w-100 col-3 mt-3" name="add" id="add-user">Ajouter</button><br>
                    </form>
                </div>
            </div>
        </div>
    
    <!-- Modal Edit -->
    <div class="modal-container-edit">
        <div class="overlay-edit modal-trigger-edit"></div>
        <div class="my-modal-edit mt-5 justify-content-center d-grid">
            <div class="container2 rounded-3">
                <h2 class="text-center mb-4 mt-5" style="color: #fff;">Modifier un utilisateur</h2>
                    <form action="" method="post">
                        <div class="mt-3">
                            <input type="text" name="username-edit" id="username-edit" placeholder="Nom d'utilisateur" class="rounded-2 col-3 w-100 ps-1" required><br>
                            <label for="username-edit" id="error-username-edit" class="form-label fw-bold" style="color: red;visibility: hidden;">Username déja utilisé</label>
                        </div>
                        
                        <div class="mt-3">
                            <input type="email" name="email-edit" id="email-edit" placeholder="Email" class="rounded-2 col-3 w-100 ps-1" required ><br>
                            <label for="email-edit" id="error-email-edit fw-bold" class="form-label" style="color: red;visibility: hidden;">Email déja utilisé</label>
                        </div>

                        <div class="mt-3 d-flex justify-content-center align-items-center gap-2">
                            <input type="password" name="password-edit" id="password-edit" placeholder="Mot de passe (Laissez vide pour pas modifier)" class="rounded-2 mb-3 col-3 flex-grow-1 ps-1"> 
                            <input class="checkbox form-check mb-2" type="checkbox" name="nochange" value="1" id="checkbox">
                        </div>

                        <div class="mt-3" >
                            <span style="color: #fff;font-size: 20px;">Status</span><br>
                            <div class="form-check" style="display: inline-block;">
                                <input class="form-check-input" type="radio" name="status-edit" id="admin-edit" value="1" required>
                                <label class="form-check-label" for="admin-edit" style="color: #fff;font-size: 15px;">Admin</label>
                            </div>

                            <div class="form-check" style="display: inline-block;margin-left: 10px;">
                                <input class="form-check-input" type="radio" name="status-edit" id="user-edit" value="0">
                                <label class="form-check-label" for="user-edit" style="color: #fff;font-size: 15px;">User</label>
                            </div>
                        </div>
                        
                        <button type="submit" class="edit btn d-grid w-100 col-3 mt-3" name="edit" id="edit-user">Modifier</button><br>
                        <input type="hidden" id="id_user_edit" name="id_user">
                        <input type="hidden" id="email_user_edit" name="email_user">
                    </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal-container-delete">
        <div class="overlay-delete modal-trigger-delete"></div>

        <div class="my-modal-delete p-3 rounded-3">
            <h4 class="fw-semibold mb-3">Confirmer la suppression</h4>
            <hr class="mb-2">
            <span class="fs-5 mb-5">Êtes-vous sûr de vouloir supprimer l'utilisateur <strong id="username-delete"></strong> ?</span>
            <hr class="mt-2 mb-3">
            <div class="buttons d-flex w-100 h-100 gap-3 justify-content-end">
                <button class="cancel btn btn-secondary modal-trigger-delete fs-5">Annuler</button>
                <form action="" method="post">
                    <button class="supp btn btn-danger modal-trigger-delete fs-5" id="supp" name="delete">Supprimer</button>
                    <input type="hidden" id="id_user_delete" name="id_user">
                    <input type="hidden" id="email_user_delete" name="email_user">

                </form>
            </div>
        </div>
    </div>
    <div class="my-container">
        <?php if (count($res)>0) :?>
            <table class="my-table">
                <thead class="header">
                    <tr>
                        <th colspan="6" style="text-align: center;font-size: 20px;font-weight: bold;">USER LIST (<?= count($res) ?>)</th>
                    </tr>
                    <tr class="main">
                        <th>USERNAME</th>
                        <th>EMAIL</th>
                        <th>STATUS</th>
                        <th>CREATED DATE</th>
                        <th>UPDATED DATE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>

                <?php
                    for($i=0;$i<count($res);$i++)
                    {?> 
                        <tr class="content">
                            <td class="username"><?= $res[$i]["Username"] ?></td>
                            <td class="email"><?= $res[$i]["Email"] ?></td>
                            <td class="status"><?php if ($res[$i]["Admin"] == 1) : echo "Admin" ; else : echo "User" ; endif ;?></td>
                            <td class="created_at"><?= $res[$i]["Created_at"] ?></td>
                            <td class="updated_at"><?= $res[$i]["Updated_at"] ?></td>
                            <td class="action h-100 d-flex flex-row justify-content-center align-items-center p-2 gap-2">
                                <button data-username="<?= $res[$i]["Username"] ?>" data-id="<?= $res[$i]["id"] ?>" class="button button_delete delete">Supprimer</button>
                                <button data-id="<?= $res[$i]["id"] ?>" data-email="<?= $res[$i]["Email"] ?>"  data-username="<?= $res[$i]["Username"] ?>" data-status="<?= $res[$i]["Admin"] ?>" class="button button_edit edit">Modifier</button>
                            </td>
                        </tr>
                <?php } ?>
                
            </table>
                    <button class="button add modal-trigger-add">Ajouter</button>
            <?php else :?>
                <h2 style="color:red ; font-size:50px">DATABASE EMPTY</h2>
            <?php endif ?>
        </div> 
        
        <script>
            const overlay_add = document.querySelectorAll(".modal-trigger-add");
            const overlay_delete = document.querySelectorAll(".modal-trigger-delete");
            const overlay_edit = document.querySelectorAll(".modal-trigger-edit");

            const button_delete = document.querySelectorAll(".button_delete");
            const button_edit = document.querySelectorAll(".button_edit");
            const checkbox = document.getElementById("checkbox");
            const checkbox_add = document.getElementById("checkbox_add");

            // Check identifiants valides
            const username_add = document.getElementById("username-add");
            const email_add = document.getElementById("email-add");
            const password_add = document.getElementById("password-add");
            const button_add_user= document.getElementById("add-user");

            const username_edit = document.getElementById("username-edit");
            const email_edit = document.getElementById("email-edit");
            const password_edit = document.getElementById("password-edit");
            const button_edit_user = document.getElementById("edit-user");

            let username_value ;
            let email_value;

            // Add | Username , Email et Password
            button_add_user.addEventListener("click",()=>{
                let check = false;
                let already = false;

                 // Username
                document.querySelectorAll(".content").forEach(content => {
                    if (!check)
                    {
                        if (username_add.value.toLocaleLowerCase()==content.children[0].textContent.toLowerCase()){
                            document.getElementById("error-username-add").style.visibility="visible";
                            document.getElementById("add-user").setAttribute("type","button");
                            check=true;
                            already=true;
                        }
                        else{
                            document.getElementById("error-username-add").style.visibility="hidden";
                        }
                    }
                });

                 // Email
                check = false;
                document.querySelectorAll(".content").forEach(content => {
                    if (!check && !already)
                    {
                        if (email_add.value.toLocaleLowerCase()==content.children[1].textContent.toLowerCase()){
                            document.getElementById("error-email-add").style.visibility="visible";
                            document.getElementById("add-user").setAttribute("type","button");
                            check=true;
                            already=True;
                        }
                        else{
                            document.getElementById("error-email-add").style.visibility="hidden";
                        }
                    }
                });

                if (!already)
                    document.getElementById("add-user").setAttribute("type","submit");

            })

            // Edit | Username , Email et Password
            button_edit_user.addEventListener("click",()=>{
                let check = false;
                let already = false;

                 // Username
                document.querySelectorAll(".content").forEach(content => {
                    if (!check)
                    {
                        if (username_edit.value.toLowerCase()==content.children[0].textContent.toLowerCase() && username_edit.value.toLowerCase()!=username_value){
                            document.getElementById("error-username-edit").style.visibility="visible";
                            document.getElementById("edit-user").setAttribute("type","button");
                            check=true;
                            already=true;
                        }
                        else{
                            document.getElementById("error-username-edit").style.visibility="hidden";
                        }
                    }
                });

                 // Email
                check = false;
                document.querySelectorAll(".content").forEach(content => {
                    if (!check && !already)
                    {
                        if (email_edit.value.toLowerCase()==content.children[1].textContent.toLowerCase() && email_edit.value.toLowerCase()!=email_value){
                            document.getElementById("error-email-edit").style.visibility="visible";
                            document.getElementById("edit-user").setAttribute("type","button");
                            check=true;
                            already=true;
                        }
                        else{
                            document.getElementById("error-email-add").style.visibility="hidden";
                        }
                    }
                });

                if (!already)
                    document.getElementById("edit-user").setAttribute("type","submit");
                    button_add_user.form.submit();
            })

            // add modal
            overlay_add.forEach(overlay =>overlay.addEventListener("click",()=>{
                document.querySelector(".modal-container-add").classList.toggle("active-add");
                document.getElementById("error-email-add").style.visibility="hidden";
                document.getElementById("error-username-add").style.visibility="hidden";
                username_add.value="";
                email_add.value="";
            }))

            // edit modal

            overlay_edit.forEach(overlay =>overlay.addEventListener("click",()=>{
                document.querySelector(".modal-container-edit").classList.remove("active-edit");
                document.getElementById("error-email-edit").style.visibility="hidden";
                document.getElementById("error-username-edit").style.visibility="hidden";
                username_edit.value="";
                email_edit.value="";
            }))

            button_edit.forEach(edit => edit.addEventListener("click",()=>{
                document.querySelector(".modal-container-edit").classList.add("active-edit");
                document.getElementById("username-edit").value=edit.dataset.username;
                document.getElementById("email-edit").value=edit.dataset.email;
                document.getElementById("id_user_edit").value=edit.dataset.id;
                document.getElementById("email_user_edit").value=edit.dataset.email;
                username_value = edit.dataset.username.toLowerCase();
                email_value = edit.dataset.email.toLowerCase();
                if (edit.dataset.status=="1")
                {
                    document.getElementById("admin-edit").setAttribute("checked","checked");
                }
                else
                {
                    document.getElementById("user-edit").setAttribute("checked","checked");
                }
            }))

            // delete modal
            overlay_delete.forEach(overlay => overlay.addEventListener("click",()=>{
                document.querySelector(".modal-container-delete").classList.remove("active-delete");
            }))

           button_delete.forEach(del=> del.addEventListener("click",()=>{
                document.querySelector(".modal-container-delete").classList.add("active-delete");
                document.getElementById("username-delete").innerHTML=del.dataset.username;
                document.getElementById("id_user_delete").value=del.dataset.id;
                document.getElementById("email_user_delete").value=del.dataset.email;

            }))

            // Check box password
            checkbox.addEventListener("change",()=>{
                const pwd=document.getElementById("password-edit");
                if (pwd.getAttribute("type")=="text")
                {
                    pwd.setAttribute("type","password")
                }
                else
                {
                    pwd.setAttribute("type","text") 
                }     
            })

             checkbox_add.addEventListener("change",()=>{
                const pwd=document.getElementById("password-add");
                if (pwd.getAttribute("type")=="text")
                {
                    pwd.setAttribute("type","password")
                }
                else
                {
                    pwd.setAttribute("type","text") 
                }     
            })
        </script>
</body>
</html>