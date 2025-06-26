<?php
    session_start();
    require_once "connection.php";
    if (!isset($_SESSION["username"]))
    {
        header("location:login.php");
        exit;
    }
    $etablissements=$_SESSION["etablissements"];
    function get_ville($connexion,$id)
    {
      $requête = "SELECT nom from villes WHERE id = :id";
      $stmt=$connexion->prepare($requête);
      $stmt->execute([":id"=>$id]);
      $res= $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $res[0]["nom"];
    }
?>
<!DOCTYPE html>
<html lang="fr">
  <?php require_once "_header.php" ;?> 
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    body {
      background-color: #121212 !important;
      color: #f0f0f0;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }

    main.school-listing {
      max-width: 1000px;
      margin: auto;
      padding: 40px 20px;
    }

    main h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 2rem;
      color: #ffffff;
    }

    .search-bar {
      text-align: center;
      margin-bottom: 40px;
    }

    .search-bar input {
      width: 60%;
      padding: 12px 20px;
      font-size: 1rem;
      border-radius: 8px;
      border: none;
      background-color: #2c2c2c;
      color: #f0f0f0;
      outline: none;
      transition: background-color 0.3s ease;
    }

    .search-bar input::placeholder {
      color: #aaa;
    }

    .search-bar input:focus {
      background-color: #3a3a3a;
    }

    .school-card {
      display: flex;
      gap: 20px;
      background-color: #1e1e1e;
      border-radius: 12px;
      margin-bottom: 30px;
      padding: 20px;
      box-shadow: 0 0 10px #00000050;
      opacity: 1;
      transition: opacity 0.5s ease;
    }

    .school-card.hidden {
      opacity: 0;
      pointer-events: none;
      height: 0;
      margin: 0;
      padding: 0;
      overflow: hidden;
    }

    .school-card img {
      width: 150px;
      height: auto;
      border-radius: 8px;
      background-color: #ffffff;
      padding: 5px;
    }

    .school-card .info h3 {
      color: #4da6ff;
      margin-bottom: 8px;
      font-size: 1.3rem;
    }

    .school-card .info p {
      color: #cccccc;
      margin-bottom: 12px;
    }

    .school-card .btn {
      background-color: #4da6ff;
      color: #fff;
      padding: 8px 16px;
      border-radius: 6px;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.3s ease;
    }

    .school-card .btn:hover {
      background-color: #3399ff;
    }

.content
{
  position:absolute;
  height:100%;
  width:100%;
  display:flex;
  justify-content:center;
  align-items:center;
  flex-direction:column;
}

.retour 
{
    margin-top:40px;
    height: 50px;
    width: 250px;
    border-radius: 8px;
    background-color: #e74c3c;
    border-color: #e74c3c;
    transition: transform 0.3s;
    font-size: 18px;
    
}

.retour:hover
{
    cursor:pointer;
    transform:scale(1.03);
}
  </style>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

  <script src="/Js/script.js" defer></script>
</head>
<body>
  <?php if(count($etablissements)>0):?>
  <main class="school-listing">
    <h2 style="text-transform: capitalize;"><?php if($_SESSION["domaine_selection"]!="ALL"):?>ECOLES DE <?=$_SESSION["domaine_selection"];else:?>TOUTES LES ECOLES<?php endif;?></h2>
      
    <div class="search-bar">
      <input type="search" id="search-bar" placeholder="Rechercher une école...">
    </div>

    <?php foreach ($etablissements as $etablissement) : ?>
      <div class="school-card">
        <img class="w-50" style="min-height: 300px; max-width: 400px;" src="https://raw.githubusercontent.com/NathanSpmGoat/Projet_Ecole/main/images/<?=$etablissement["image"]?>" alt="image <?=$etablissement["image"]?>" />
        <div class="info">
          <h3><?=strtoupper($etablissement["nom"]);?></h3>
          <p><?=$etablissement["description"]?></p>
          <p><?="VILLE : ". get_ville($connection,$etablissement["ville_id"]);?></p>
          <a href="<?=$etablissement["site_web"]?>" class="btn w-100" target="_blank">Voir plus</a>
        </div>
      </div>
    <?php endforeach; ?>
  </main>
  <?php else:?>
    <div class="content">
      <h2 style="text-align: center;color:rgb(200, 4, 4);font-size: 2rem;margin-bottom: 20px;width:fit-content;text-transform: capitalize;">Aucun établissement trouvé pour "<?php if($_SESSION["domaine_selection"]!="ALL"):?>ECOLES DE <?=strtoupper($_SESSION["domaine_selection"]);else:?>TOUTES LES ECOLES<?php endif;?>" <?=strtoupper(isset($_SESSION["ville_selection"])?"| Ville : ".$_SESSION["ville_selection"]:"");?>"</h2>
      <button class="retour" onclick="window.location.href='accueil.php'">Retour</button>
    </div>
    <?php endif;?>
    <script>
      const infos = document.querySelectorAll(".school-card");
      const searchbar = document.getElementById("search-bar");

      // Recherche avancée des écoles

      searchbar.addEventListener("input", () => {
        const inputValue = searchbar.value.toLowerCase();
        infos.forEach(info => {
          const text = info.children[1].children[0].innerHTML.toLowerCase();

          if (text.includes(inputValue)) {
            info.classList.remove("hidden");
          } else {
            info.classList.add("hidden");
          }
        });
      });
    </script>
</body>
</html>
