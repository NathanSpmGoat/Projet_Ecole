<?php
    require_once "connection.php";
    session_start();
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

    if ($_SERVER["REQUEST_METHOD"] == "GET") 
    {
        if (isset($_GET["domaine"])) 
        {
            $requête="SELECT * FROM domaines ORDER BY id";
            $stmt=$connection->query($requête);
            $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
            $select="Domaine";
            $_SESSION["select"]=$select;
        }
        else
        {
            $requête="SELECT * FROM villes ORDER BY id";
            $stmt=$connection->query($requête);
            $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
            $select="Ville";
            $_SESSION["select"]=$select;
        }

        if (isset($_GET["add"])){
            $value = htmlspecialchars($_GET["valeur"]);
            $requête = "INSERT INTO " .$select."s (nom) VALUES (:nom)";
            $stmt=$connection->prepare($requête);
            $stmt->bindParam("nom",$value);
            $stmt->execute();
            usleep(400000);
            header("location:villes_domaines.php");
            exit;
        }
        elseif (isset($_GET["delete"]))
        {
            $requête = "DELETE FROM " .$select."s WHERE id=:id";
            $stmt = $connection->prepare($requête);
            $stmt->bindParam(":id",$_GET["id_item"]);
            $stmt->execute();
            usleep(400000);
            header("location:villes_domaines.php");
            exit;
        }
        elseif (isset($_GET["edit"]))
        {   
            $valeur = htmlspecialchars($_GET["ville_domaine"]);
            $requête = "UPDATE " . $select ."s SET nom=:nom WHERE id=:id";
            $stmt = $connection->prepare($requête);
            $stmt->bindParam(":nom",$valeur);
            $stmt->bindParam(":id",$_GET["id_item"]);
            $stmt->execute();
            usleep(400000);
            header("location:villes_domaines.php");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once "_header.php" ;?> 
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/style8.css">
</head>
<body>
     <!-- Modal Delete -->
        <div class="modal-container-delete">
            <div class="overlay-delete modal-trigger-delete"></div>
            <div class="my-modal-delete p-3 rounded-3">
                <h4 class="fw-semibold mb-3">Confirmer la suppression</h4>
                <hr class="mb-2">
                <span class="fs-5 mb-5">Êtes-vous sûr de vouloir supprimer <?=$select=="domaine" ? "le ".strtolower($select): "la ".strtolower($select)?> <strong id="item-delete"></strong> ?</span>
                <hr class="mt-2 mb-3">
                <div class="buttons d-flex w-100 h-100 gap-3 justify-content-end">
                    <button class="cancel btn btn-secondary modal-trigger-delete fs-5">Annuler</button>
                    <form action="">
                        <button class="supp btn btn-danger fs-5" id="supp" name="delete">Supprimer</button>
                        <input type="hidden" name="id_item" id="id_item_delete">
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal-container-edit">
            <div class="overlay-edit modal-trigger-edit"></div>
            <div class="my-modal-edit">
                <div class="container2 rounded-3 pt-1" style="height: fit-content;">
                    <h2 class="text-center mb-4 mt-5" style="color: #fff;">Modifier un enregistrement</h2>
                    <form action="">
                        <div class="mt-3" style="width: 100%; padding:1px">
                            <input class="form-control" type="text" name="ville_domaine" id="ville_domaine" style="width: 100%;font-size: 20px;" required>
                        </div>
                        <button type="input" class="edit btn d-grid w-100 col-3 mt-4" style="background-color: #3498db;border-color: #3498db;margin-top: 10px;color:#000" name="edit" id="edit-btn">Modifier</button>
                        <label for="ville_domaine" id="error" style="color :red;font-weight: bold;padding-bottom: 10px;"></label>
                        <input type="hidden" name="id_item" id="id_item_edit">
                    </form>
                </div>
            </div>
        </div>

    <div class="main pt-5">
        <div class="display">
            <table>
                <thead class="header">
                    <tr>
                        <th colspan="2" style="text-align: center;font-size: 20px;font-weight: bold;text-transform: uppercase;">LIST <?= $select . " (" . count($res) . ")";?></th>
                    </tr>
                    <tr class="fs-5">
                        <th style="text-transform: uppercase;"><?= $select;?></th>
                        <th margin-left:40px>ACTION</th>
                    </tr>
                </thead>
                <tbody class="content">
                    <?php foreach ($res as $row) : ?>
                        <tr class="content">
                            <td name="nom" class="fs-5 w-50"><?= $row["nom"]; ?></td>
                            <td class="action p-2">
                                <button class="delete button_delete" data-nom="<?= $row["nom"]; ?>" data-id="<?= $row["id"]; ?>">Supprimer</button>
                                <button class="edit button_edit" data-nom="<?= $row["nom"]; ?>" data-id="<?= $row["id"]; ?>">Modifier</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="container">
            <h2 class="text-center mb-4 mt-5" style="color: #fff;">Ajouter <?= ($select == "Domaine") ? "un domaine" : "une ville"; ?></h2>
            <form action="">
                <div class="mt-3">
                    <input type="text" name="valeur" id="valeur" placeholder="<?= $select;?>" class="rounded-2 col-3 w-100 ps-1 form-control" required><br>
                </div>
                <button type="submit" class="add btn d-grid w-100 col-3 mt-0" name="add" id="add">Ajouter</button>
                <label for="add" id="error_add" style="color :red;font-weight: bold;padding-bottom: 10px;"></label>
            </form>
        </div>

        <script>
            const modal_edit = document.querySelectorAll(".modal-trigger-edit");
            const modal_delete = document.querySelectorAll(".modal-trigger-delete");

            const button_edit = document.querySelectorAll(".button_edit");
            const button_delete = document.querySelectorAll(".button_delete");

            const button_edit_confirm = document.getElementById("edit-btn");
            const button_add_confirm = document.getElementById("add");
            const ville_domaine = document.getElementById("ville_domaine");
            const ville_domaine_add = document.getElementById("valeur");
            let item_value_edit;
            
            // Edit
            button_edit_confirm.addEventListener("click",()=>{
                let check = false;
                document.querySelectorAll(".content").forEach(content =>{
                    if (!check)
                    {
                        if(content.children[0].textContent.toLocaleLowerCase() == ville_domaine.value.toLocaleLowerCase() && item_value_edit.toLocaleLowerCase()!=ville_domaine.value.toLocaleLowerCase()){
                            document.getElementById("error").innerHTML = `${ville_domaine.value} existe déja`;
                            button_edit_confirm.setAttribute("type","button");
                            check=true;
                        }
                        else
                        {
                            document.getElementById("error").innerHTML = "";
                            button_edit_confirm.setAttribute("type","input");
                        }
                    }
                })
            })

            // Add

            button_add_confirm.addEventListener("click",()=>{
                let check = false;
                document.querySelectorAll(".content").forEach(content =>{
                    console.log(ville_domaine_add.value);
                    if (!check)
                    {
                        if(content.children[0].textContent.toLocaleLowerCase() == ville_domaine_add.value.toLocaleLowerCase()){
                            document.getElementById("error_add").innerHTML = `${ville_domaine_add.value} existe déja`;
                            button_add_confirm.setAttribute("type","button");
                            check=true;
                        }
                        else
                        {
                            document.getElementById("error_add").innerHTML = "";
                            button_add_confirm.setAttribute("type","input");
                        }
                    }
                })
            })

            // Modal Delete
            modal_delete.forEach(overlay => overlay.addEventListener("click",()=>{
                document.querySelector(".modal-container-delete").classList.toggle("active-delete");
            }))

            button_delete.forEach(btn => btn.addEventListener("click",()=>{
                document.querySelector(".modal-container-delete").classList.toggle("active-delete");
                document.getElementById("item-delete").innerHTML=btn.dataset.nom;
                document.getElementById("id_item_delete").value=btn.dataset.id;
            }))

            // Modal Edit
            modal_edit.forEach(overlay => overlay.addEventListener("click",()=>{
                document.querySelector(".modal-container-edit").classList.toggle("active-edit");
                document.getElementById("error").innerHTML = "";
                ville_domaine.value="";
            }))

            button_edit.forEach(btn => btn.addEventListener("click",()=>{
                document.querySelector(".modal-container-edit").classList.toggle("active-edit");
                document.getElementById("ville_domaine").value=btn.dataset.nom;
                document.getElementById("id_item_edit").value=btn.dataset.id;
                item_value_edit = btn.dataset.nom;
            }))

        </script>
    </div>  
</body>