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
        $requête="SELECT * FROM etablissements";
        $stmt=$connection->query($requête);
        $ecole=$stmt->fetchAll(PDO::FETCH_ASSOC);
        

        $stmt1=$connection->query("SELECT * FROM etablissements WHERE domaine_id IS NULL and ville_id IS NULL");
        $ecoles=$stmt1->fetchAll(PDO::FETCH_ASSOC);

        $stmt2=$connection->prepare("SELECT * FROM domaines");
        $stmt2->execute();
        $domaines=$stmt2->fetchAll(PDO::FETCH_ASSOC);

        $stmt3=$connection->prepare("SELECT * FROM villes");
        $stmt3->execute();
        $villes=$stmt3->fetchAll(PDO::FETCH_ASSOC);

        if ($_SERVER["REQUEST_METHOD"]=="GET")
        {
            if (isset($_GET["add"]))
            {
                $nom = trim(htmlspecialchars($_GET["ecole"])) ?? null;
                $description = htmlspecialchars($_GET["description"]) ?? null;
                $site_web = trim(htmlspecialchars($_GET["site_web"])) ?? null;
                $image = trim(htmlspecialchars($_GET["image"])) ?? null;
                $domaine = $_GET["domaines"] ?: null;
                $ville = $_GET["villes"] ?: null;

                // Préparation de la requête
                $requête = "INSERT INTO etablissements (nom, domaine_id, ville_id, description, site_web, image)
                VALUES (:nom, :domaine_id, :ville_id, :description, :site_web, :image)";
                $stmt = $connection->prepare($requête);

                $stmt->execute([
                    ':nom' => $nom,
                    ':domaine_id' => $domaine,
                    ':ville_id' => $ville,
                    ':description' => $description,
                    ':site_web' => $site_web,
                    ':image' => $image
                ]);
                usleep(400000);
                header("location:data.php");
            }
            elseif (isset($_GET["delete"]))
            {
                $requête = "DELETE FROM etablissements WHERE id=:id";
                $stmt=$connection->prepare($requête);
                $stmt->bindParam(":id",$_GET["id-ecole"]);
                $stmt -> execute();
                usleep(400000);
                header("location:data.php");
            }
            elseif (isset($_GET["edit"]))
            {
                $nom = htmlspecialchars($_GET["ecole"]) ?? null;
                $description = htmlspecialchars($_GET["description"]) ?? null;
                $site_web = trim(htmlspecialchars($_GET["site_web"])) ?? null;
                $image = trim(htmlspecialchars($_GET["image"]))?? null;
                $domaine = $_GET["domaines"] ?: null;
                $ville = $_GET["villes"] ?: null;
                $requête = "SELECT * FROM etablissements WHERE nom = :nom";
                $stmt = $connection->prepare($requête);
                $stmt->bindParam(":nom", $nom);
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);

                if (empty($res["domaine_id"])||empty($res["ville_id"]))
                {
                    $requête = "DELETE FROM etablissements WHERE id = :id";
                    $stmt = $connection->prepare($requête);
                    $stmt->bindParam(":id", $res["id"]);
                    $stmt->execute();
                    usleep(400000);
                }

                $requête = "UPDATE etablissements SET nom=:nom, domaine_id=:domaine_id, ville_id=:ville_id, description=:description,
                 site_web=:site_web, image=:image WHERE id=:id";
                $stmt = $connection->prepare($requête);

                $stmt->execute([
                    ':nom' => $nom,
                    ':domaine_id' => $domaine,
                    ':ville_id' => $ville,
                    ':description' => $description,
                    ':site_web' => $site_web,
                    ':image' => $image,
                    ':id'=> $_GET["id-ecole"],
                ]);
                usleep(400000);
                header("location:data.php");
            }
        }

?>
<!DOCTYPE html>
<html lang="fr">
    <?php require_once "_header.php" ;?> 
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="Css/style2.css">
</head>
<body>
    <!-- Modal Add -->
        <div class="modal-container-add">
            <div class="overlay-add modal-trigger-add"></div>
            <div class="my-modal-add">
                <div class="container2 rounded-3" style="height:fit-content;margin-bottom: 20px;">
                    <h2 class="text-center mb-4 mt-5 fw-bold" style="color: #fff;">Ajouter un enregistrement</h2>
                    <form action="">
                        <div class="div-input mt-3" style="width: 100%; padding:1px">
                            <input type="text" class="form-control" name="ecole" id="ecole" style="width: 100%;font-size: 20px;" placeholder="Nom de l'école" required>
                            <label for="ecole" style="color: red;font-weight: bold;display: none;" id="error-add">Cette école existe déja</label>
                        </div>
                        <input type="hidden" name="page_data" value="ecole">
                        <div class="mt-4">
                            <select class="form-select form-select-lg" name="domaines" id="domaines" style="width: 100%; padding:3px" required>
                                <optgroup label="Domaines">
                                    <option value="0" disabled selected>choisissez un domaine</option>
                                    <option value="">Aucune</option>
                                    <?php foreach ($domaines as $domaine) : ?>
                                        <option value="<?=$domaine["id"];?>"  name="domaine"><?=$domaine["nom"];?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                        </div>

                        <div class="mt-4 d-flex align-items-center">
                            <select class="form-select form-select-lg" name="villes" id="villes" style="width: 100%; padding:3px" required>
                                <optgroup label="Villes">
                                    <option value="0" disabled selected>choisissez une ville</option>
                                    <option value="" >Aucun</option>
                                    <?php foreach ($villes as $ville) : ?>
                                        <option value="<?=$ville["id"];?>" name="ville"><?=$ville["nom"];?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                        </div>

                        <div class="div-input mt-4" style="width: 100%; padding:1px">
                            <textarea name="description" id="description" class="form-control" style="width: 100%;font-size: 20px;" placeholder="Description de l'école" required></textarea>
                        </div>

                        <div class="div-input mt-4" style="width: 100%; padding:1px">
                            <textarea name="site_web" id="site_web" class="form-control" style="width: 100%;font-size: 20px;" placeholder="Lien de l'école" required></textarea>
                        </div>

                        <div class="div-input mt-3" style="width: 100%; padding:1px">
                            <input type="text" name="image" id="image" style="width: 100%;font-size: 20px;" class="form-control" placeholder="Image d'illustration (Nom sur le github)">
                        </div>

                        <button class="add btn d-grid w-100 col-3 mt-4" name="add" id="add">Ajouter</button><br>
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
                <span class="fs-5 mb-5">Êtes-vous sûr de vouloir supprimer l'école <strong id="username-delete"></strong> ?</span>
                <hr class="mt-2 mb-3">
                <div class="buttons d-flex w-100 h-100 gap-3 justify-content-end">
                    <button class="cancel btn btn-secondary modal-trigger-delete fs-5">Annuler</button>
                    <form action="">
                        <button class="supp btn btn-danger fs-5" id="supp" name="delete">Supprimer</button>
                        <input type="hidden" name="id-ecole" id="id-ecole-delete">
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal-container-edit">
            <div class="overlay-edit modal-trigger-edit"></div>
            <div class="my-modal-edit p-3 rounded-3">
                <h2 class="text-center mb-4 mt-3" style="color: #fff;">Modifier un enregistrement</h2>
                <form action="">
                    <div class="all">
                        <div class="mt-3 d-flex w-100 gap-2">
                            <div class="check w-100">
                                <select class="form-select form-select-lg" name="ecole" id="ecoles" style="width: 100%; padding:3px" >
                                    <option value="none" disabled class="text-center">Ecole non attribuée</option>
                                    <optgroup label="Ecoles">
                                        <?php if (count($ecoles)>0):?>
                                            <?php foreach ($ecoles as $e) : ?>
                                                <option value="<?=$e["nom"];?>"><?=$e["nom"];?></option>
                                            <?php endforeach; ?>
                                        <?php endif?>
                                    </optgroup>
                                </select>
                                <input type="hidden" id="nb-ecoles" value=<?=count($ecoles)?>>
                                <input type="text" class="form-control fs-5" style="display: none;" disabled id="ecole-custom" name="ecole" placeholder="Veuillez saisir une nouvelles école">
                            </div>
                            <input type="checkbox" class="custom form-check" name="custom" id="custom">
                        </div>
                        <label for="ecole-custom" style="color:red;font-weight: bold;display:none" id="error-edit">Ecole existant déja</label>
                    </div>

                    <div class="mt-4">
                        <select class="form-select form-select-lg" name="domaines" id="domaines-edit" style="width: 100%; padding:3px">
                            <optgroup label="Domaines">
                            <option name="domaine" disabled selected>choisissez un domaine</option>
                                <?php foreach ($domaines as $domaine) : ?>
                                    <option class="domaine_item_edit" value="<?=$domaine["id"];?>"><?=$domaine["nom"];?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>

                    <div class="mt-4 d-flex align-items-center">
                        <select class="form-select form-select-lg" name="villes" id="villes-edit" style="width: 100%; padding:3px">
                            <optgroup label="Villes">
                            <option disabled selected>choisissez une ville</option>
                                <?php foreach ($villes as $ville) : ?>
                                    <option class="ville_item_edit" value="<?=$ville["id"];?>"><?=$ville["nom"];?></option>
                                <?php endforeach;?>
                            </optgroup>
                        </select>
                    </div>
                    <div class="mt-4" style="width: 100%; padding:1px">
                        <textarea name="description" class="form-control" id="description_edit" style="width: 100%;font-size: 20px;" placeholder="Description de l'école" required></textarea>
                    </div>

                    <div class="mt-4" style="width: 100%; padding:1px">
                        <textarea name="site_web" class="form-control" id="site_web_edit" style="width: 100%;font-size: 20px;" placeholder="Lien de l'école" required></textarea>
                    </div>

                    <div class="mt-3" style="width: 100%; padding:1px">
                        <input type="text" name="image" id="image_edit" style="width: 100%;font-size: 20px;" class="form-control" placeholder="Image d'illustration (Nom sur le github)">
                    </div>

                    <button type="submit" class="edit btn d-grid w-100 col-3 mt-4" style="margin-top: 10px;" name="edit" id="edit">Modifier</button><br>
                    <input type="hidden" name="id-ecole" id="id-ecole-edit">
                </form>
            </div>
        </div>

    <div class="my-container">
        <?php if (count($ecole)>0) :?>
            <table class="my-table">
                <thead class="header">
                    <tr>
                        <th colspan="4" style="text-align: center;font-size: 20px;font-weight: bold;">ECOLE LIST (<?= count($ecole) ?>)</th>
                    </tr>
                    <tr class="main">
                        <th>ECOLE</th>
                        <th>DOMAINE</th>
                        <th>VILLE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>

                <?php
                    for($i=0;$i<count($ecole);$i++)
                    {
                        $domaine_id= $ecole[$i]['domaine_id']?? '';
                        if (!empty($domaine_id))
                        {
                        $stmt2 = $connection->prepare("SELECT nom FROM domaines WHERE id = ?");
                        $stmt2->execute([$domaine_id]);
                        $domaines = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                        }
                        else
                            unset($domaines);

                        $ville_id=$ecole[$i]['ville_id'] ?? "";
                        if (!empty($ville_id))
                        {
                        $stmt3 = $connection->prepare("SELECT nom FROM villes WHERE id = ?");
                        $stmt3->execute([$ville_id]);
                        $villes = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                        }
                        else
                            unset($villes);

                        ?> 
                        <tr class="content">
                            <td class="ecole"><?= $ecole[$i]["nom"] ?></td>
                            <td class="domaine p-4"><?= $domaines[0]["nom"] ??"NaN" ?></td>
                            <td class="ville"><?= $villes[0]["nom"] ?? "NaN" ?></td>
                            <td class="action">
                                <button class="button delete button_delete" data-ecole="<?= $ecole[$i]["nom"] ?>" data-id="<?= $ecole[$i]["id"] ?>">Supprimer</button>
                                <button class="button edit button_edit" data-ecole="<?= $ecole[$i]["nom"] ?>" data-id="<?= $ecole[$i]["id"] ?>" data-description="<?= $ecole[$i]["description"]?>"
                                data-site_web="<?= $ecole[$i]["site_web"]?>" data-image="<?= $ecole[$i]["image"]?>" data-ville="<?= $villes[0]["nom"] ?? "" ?>"
                                data-domaine="<?= $domaines[0]["nom"] ?? "" ?>" >Modifier</button>
                            </td>
                        </tr>
                <?php } ?>
                <form action="villes_domaines.php">
                    <tr class="add_preci">
                        <td colspan="2"><button type="submit" class="button add" name="ville">Villes</button></td>
                        <td colspan="2"><button type="submit" class="button add" name="domaine">Domaines</button></td>
                    </tr>
                </form>
            </table>
                <button class="button add button_add">Ajouter</button>
            <?php else :?>
                <h2 style="color:red ; font-size:50px">DATABASE EMPTY</h2>
            <?php endif ?>
        </div> 

        <script>
            const modal_add = document.querySelectorAll(".modal-trigger-add");
            const modal_edit = document.querySelectorAll(".modal-trigger-edit");
            const modal_delete = document.querySelectorAll(".modal-trigger-delete");

            const button_add = document.querySelectorAll(".button_add");
            const button_edit = document.querySelectorAll(".button_edit");
            const button_delete = document.querySelectorAll(".button_delete");

            const button_edit_confirm = document.getElementById("edit");
            const button_add_confirm = document.getElementById("add");

            const villes = document.querySelectorAll(".ville_item");
            const domaines = document.querySelectorAll(".domaine_item");
            const custom = document.getElementById("custom");
            const ecoles = document.getElementById("ecoles");
            const ecole_custom = document.getElementById("ecole-custom");
            let ecole_select;
            
            custom.addEventListener("input",function(){
                if (ecoles.style.display != "none")
                {
                    ecoles.style.display = "none"
                    ecoles.disabled = true;
                    ecole_custom.style.display="inline-block";
                    ecole_custom.disabled = false;
                    document.getElementById("error-edit").style.display="none";
                }
                else
                {
                    ecoles.style.display ="block"
                    ecole_custom.style.display="none";
                    ecoles.disabled = false;
                    ecole_custom.disabled = true;
                }
            })

            // Add
            button_add_confirm.addEventListener("click",()=>{
                let valid=false;
                const valeur = document.getElementById("ecole");
                document.querySelectorAll(".content").forEach(content =>{
                    if (!valid)
                    {
                        if(content.children[0].textContent.toLowerCase()==valeur.value.toLowerCase())
                        {
                            document.getElementById("error-add").style.display = "";
                            button_add_confirm.setAttribute("type","button");
                            valid=true;
                        }
                        else
                        {
                            button_add_confirm.setAttribute("type","submit");
                            document.getElementById("error-add").style.display = "none";
                        }
                    }    
                })
            })

            // Edit
            button_edit_confirm.addEventListener("click",()=>{
                if (custom.checked)
                {
                    let valid=false;
                    document.querySelectorAll(".content").forEach(content =>{
                        if (!valid)
                        {
                            console.log(content.children[0].textContent.toLowerCase() + " " + ecole_custom.value.toLowerCase());
                            if(content.children[0].textContent.toLowerCase()==ecole_custom.value.toLowerCase() && ecole_custom.value.toLowerCase()!= ecole_select )
                            {
                                document.getElementById("error-edit").style.display="";
                                button_edit_confirm.setAttribute("type","button");
                                valid=true;
                            }
                            else
                            {
                                button_edit_confirm.setAttribute("type","submit");
                                document.getElementById("error-edit").style.display="none";
                            }
                        }
                        
                    })
                }
            })
            // Modal add
            modal_add.forEach(overlay => overlay.addEventListener("click",()=>{
                document.querySelector(".modal-container-add").classList.remove("active-add");
                document.getElementById("ecole").value = "";
                document.getElementById("error-add").innerHTML = "";
                document.getElementById("error-add").style.display = "none";
                document.getElementById("description").value="";
                document.getElementById("site_web").value="";
                document.getElementById("image").value = "";
            }))

            button_add.forEach(btn => btn.addEventListener("click",()=>{
                document.querySelector(".modal-container-add").classList.add("active-add");
            }))

            // Modal Edit
            modal_edit.forEach(overlay => overlay.addEventListener("click",()=>{
                document.querySelector(".modal-container-edit").classList.remove("active-edit");
                const initialCount = parseInt(document.getElementById('nb-ecoles').value) + 1;
                while (ecoles.options.length > initialCount) {
                    ecoles.remove(ecoles.options.length - 1);
                }
                ecole_custom.value = "";
                custom.checked = false;
                ecoles.style.display ="block"
                ecole_custom.style.display="none";
            }))

            button_edit.forEach(btn => btn.addEventListener("click",()=>{
                document.querySelector(".modal-container-edit").classList.add("active-edit");
                document.getElementById("description_edit").value=btn.dataset.description;
                document.getElementById("site_web_edit").value=btn.dataset.site_web;
                document.getElementById("image_edit").value = btn.dataset.image;
                document.getElementById("id-ecole-edit").value = btn.dataset.id;

                document.querySelectorAll(".domaine_item_edit").forEach(option => {
                    option.selected = (option.textContent.trim() === btn.dataset.domaine);
                });

                document.querySelectorAll(".ville_item_edit").forEach(option => {
                    option.selected = (option.textContent.trim() === btn.dataset.ville);
                    });
                let option = document.createElement("option");
                option.value = btn.dataset.ecole;
                option.innerHTML = btn.dataset.ecole
                option.selected=true;
                ecoles.appendChild(option);
                ecole_select = btn.dataset.ecole.toLowerCase();
                
            }))

            // Modal Delete
            modal_delete.forEach(overlay => overlay.addEventListener("click",()=>{
                document.querySelector(".modal-container-delete").classList.toggle("active-delete");;
            }))

            button_delete.forEach(btn => btn.addEventListener("click",()=>{
                document.querySelector(".modal-container-delete").classList.toggle("active-delete");
                document.getElementById("username-delete").innerHTML=btn.dataset.ecole;
                document.getElementById("id-ecole-delete").value = btn.dataset.id;
            }))

        </script>
</body>
</html>