<?php
    session_start();
    require_once "connection.php";
    if (!isset($_SESSION["username"]))
    {
        header("location:login.php");
        exit;
    }
    $requête1="SELECT * FROM domaines";
    $stmt=$connection->prepare($requête1);
    $stmt->execute();
    $domaines=$stmt->fetchAll(PDO::FETCH_ASSOC);

    $requête2="SELECT * FROM villes";
    $stmt2=$connection->prepare($requête2);
    $stmt2->execute();
    $villes=$stmt2->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"]=="GET")
    {
      if (isset($_GET["rechercher"]))
      {    
        $_SESSION["domaine_selection"]=$_GET["domaine"]!="all"?$_GET["domaine"]:"ALL";
        $villes_selection=$_GET["ville"]!="all"?$_GET["ville"]:"ALL";

        $sql = "SELECT *
                FROM etablissements e
                WHERE 1=1";

        $params = [];

        if ($_SESSION["domaine_selection"] !== "ALL") {
            $sql .= " AND domaine_id = (SELECT id FROM domaines WHERE nom = :nom_domaine)";
            $params[":nom_domaine"] = $_SESSION["domaine_selection"];
        }

        if ($villes_selection!== "ALL") {
            $sql .= " AND ville_id = (SELECT id FROM villes WHERE nom = :nom_ville)";
            $params[":nom_ville"] = $villes_selection;
        }

        $stmt2 = $connection->prepare($sql);

        // Bind dynamique
        foreach ($params as $key => $value) {
            $stmt2->bindValue($key, $value);
        }

        $stmt2->execute();
        $etablissements = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        shuffle($etablissements);
        $_SESSION["etablissements"]=$etablissements;
        header("Location: etablissements.php");
        exit();
      }
    }
?>
<!DOCTYPE html>
<html lang="fr">
  <?php require_once "_header.php" ;?> 
<head>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- Leaflet Search -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    body,html
    {
      margin:0;
      padding:0;
      height:100%;
      width:100%;
      background-color: #1e1e1e;
    }
    label
    {
      color: #fff;
    }
    #carte {
      height: 500px;
      margin-top: 20px;
    }
    label
    {
      font-weight: bold;
    }

    .zone-carte ,
    .select-manuelle{
      display:none;
    }


  </style>
</head>

<body>
<div class="container pt-5">
  <form action="">
    <fieldset>
      <div class="mb-3">
        <label for="domaine">Domaine souhaité</label>
        <select id="domaine" name="domaine" class="form-select form-select-lg mb-3 fs-6" required>
          <option value="" selected disabled>Choisissez un domaine</option>
          <?php foreach ($domaines as $domaine) : ?>
            <option value="<?=$domaine["nom"];?>" name="domaine"><?=$domaine["nom"];?></option>
          <?php endforeach; ?>
          <option value="all">Tous les domaines</option>
        </select>
      </div>

      <div class="mb-3 select-manuelle" id="select-manuelle">
        <label for="choix-ville" class="form-label">Choix manuel</label>
        <select class="form-select" id="choix-ville">
          <option value="" selected disabled>Choisissez une ville</option>
          <?php foreach ($villes as $ville) : ?>
            <option value="<?=$ville["nom"];?>" name="domaine"><?=$ville["nom"];?></option>
          <?php endforeach; ?>
          <option value="all">Toutes les villes</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="choix-methode" class="form-label">Méthode de sélection de la ville</label>
        <select id="choix-methode" class="form-select fs-6" required>
          <option value="" selected disabled>Choisissez une méthode</option>
          <option value="select">Sélection via liste déroulante</option>
          <option value="carte">Utiliser la carte interactive</option>
        </select>
      </div>

      <div id="zone-carte" class="zone-carte">
        <label for="ville">Ville sélectionnée :</label>
        <input type="text" id="ville" class="form-control form-control-lg mb-3  fs-6" readonly placeholder="Choisissez une ville sur la carte ou via recherche" />
        <div id="carte" class="mb-3"></div>
      </div>

      <div>
        <button type="submit" class="btn btn-warning" name="rechercher">Rechercher</button>
        <button type="reset" class="btn btn-secondary">Annuler</button>
        <input type="hidden" id="ville_value" name="ville"></input>
      </div>
    </fieldset>
  </form>
</div>

<script>
// Villes connues avec coordonnées
const villes = {
  "paris": { nom: "Paris", lat: 48.8566, lon: 2.3522 },
  "versailles": { nom: "Versailles", lat: 48.8049, lon: 2.1204 },
  "nantes": { nom: "Nantes", lat: 47.2184, lon: -1.5536 },
  "lyon": { nom: "Lyon", lat: 45.75, lon: 4.85 },
  "marseille": { nom: "Marseille", lat: 43.2965, lon: 5.3698 },
  "toulouse": { nom: "Toulouse", lat: 43.6047, lon: 1.4442 },
  "strasbourg": { nom: "Strasbourg", lat: 48.5734, lon: 7.7521 },
  "montpellier": { nom: "Montpellier", lat: 43.6119, lon: 3.8777 },
  "jouy-en-josas": { nom: "Jouy-en-Josas", lat: 48.7608, lon: 2.1693 },
  "fontainebleau": { nom: "Fontainebleau", lat: 48.4047, lon: 2.7016 },
  "cergy": { nom: "Cergy", lat: 49.0365, lon: 2.0761 },
  "lille": { nom: "Lille", lat: 50.6292, lon: 3.0573 },
  "la-defense": { nom: "La Défense", lat: 48.8919, lon: 2.2411 },
  "neuilly-sur-seine": { nom: "Neuilly-sur-Seine", lat: 48.8846, lon: 2.2689 },
  "creteil": { nom: "Créteil", lat: 48.7904, lon: 2.4556 },
  "bordeaux": { nom: "Bordeaux", lat: 44.8378, lon: -0.5792 },
  "rennes": { nom: "Rennes", lat: 48.1173, lon: -1.6778 },
  "nancy": { nom: "Nancy", lat: 48.6921, lon: 6.1844 },
  "palaiseau": { nom: "Palaiseau", lat: 48.7144, lon: 2.2438 },
  "gif-sur-yvette": { nom: "Gif-sur-Yvette", lat: 48.7016, lon: 2.1359 },
  "villeurbanne": { nom: "Villeurbanne", lat: 45.7719, lon: 4.8902 },
  "le-kremlin-bicetre": { nom: "Le Kremlin-Bicêtre", lat: 48.8142, lon: 2.3604 },
  "aix-en-provence": { nom: "Aix-en-Provence", lat: 43.5297, lon: 5.4474 },
  "saint-germain-en-laye": { nom: "Saint-Germain-en-Laye", lat: 48.8988, lon: 2.0935 },
  "grenoble": { nom: "Grenoble", lat: 45.1885, lon: 5.7245 }
};

  // Initialisation carte
  let map = null;
  let markerGroup = null;

  const choix = document.getElementById("choix-methode");
  const select = document.getElementById("select-manuelle");
  const carte = document.getElementById("zone-carte");
  const ville_carte = document.getElementById("ville");
  const ville_select = document.getElementById("choix-ville");
  const ville = document.getElementById("ville_value");

  ville_select.addEventListener("change", () => {
    ville.value = ville_select.value;
  });

  choix.addEventListener("change", () => {
    if (choix.value == "select") {
      select.style.display = "block";
      carte.style.display = "none";
      ville_carte.required = false;
      ville_select.required = true;
    } else {
      carte.style.display = "block";
      select.style.display = "none";
      ville_select.required = false;
      ville_carte.required = true;

      if (map) return;

      map = L.map('carte').setView([46.6, 2.2], 6);

      L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        minZoom: 3,
        maxZoom: 18
      }).addTo(map);

      markerGroup = L.layerGroup().addTo(map);

      for (const key in villes) {
        const v = villes[key];
        const marker = L.marker([v.lat, v.lon])
          .bindPopup(v.nom)
          .addTo(markerGroup);

        marker.on('click', () => {
          ville_carte.value = v.nom;
          ville.value = v.nom; 
        });
      }

      L.Control.geocoder({
        defaultMarkGeocode: false
      })
        .on('markgeocode', function (e) {
          const latlng = e.geocode.center;
          map.setView(latlng, 12);
          L.marker(latlng).addTo(markerGroup).bindPopup(e.geocode.name).openPopup();
          ville_carte.value = e.geocode.name;
          ville.value = e.geocode.name;
        })
        .addTo(map);
    }
  });
</script>
</body>
</html>