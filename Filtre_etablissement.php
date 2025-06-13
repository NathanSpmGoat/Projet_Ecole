<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Choix d'établissement</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- Leaflet Geocoder -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

  <style>
    body {
      background-color: #121212;
      color: #f1f1f1;
    }

    #carte {
      height: 500px;
      margin-top: 10px;
      border: 2px solid #ccc;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h1 class="mb-4">Mes recommandations</h1>

    <form action="Etablissement.php" method="post">
      <!-- Domaine -->
      <div class="mb-3">
        <label for="domaine">Domaine souhaité :</label>
        <select id="domaine" name="domaine" class="form-select" required>
          <option value="" selected disabled>Cliquez pour choisir un domaine</option>
          <option value="architecture">Architecture</option>
          <option value="commerce">Commerce</option>
          <option value="communication">Communication</option>
          <option value="droit">Droit</option>
          <option value="economie">Économie et Gestion</option>
          <option value="informatique">Informatique</option>
          <option value="management">Management</option>
          <option value="sante">Santé</option>
          <option value="sciences_politiques">Sciences politiques</option>
          <option value="sport">Sport</option>
          <option value="statistiques">Statistiques</option>
          <option value="all">Tous les domaines</option>
        </select>
      </div>

      <!-- Mode de sélection -->
      <div class="mb-3">
        <label for="mode">Méthode de sélection :</label>
        <select id="mode" class="form-select" required>
          <option value="" disabled selected>-- Choisissez une méthode --</option>
          <option value="manuel">Saisie manuelle</option>
          <option value="carte">Carte interactive</option>
          <option value="toutes">Toutes les villes</option>
        </select>
      </div>

      <!-- Saisie manuelle -->
      <div id="selectionManuelle" class="mb-3" style="display: none;">
        <label for="villeManuelle">Ville :</label>
        <input type="text" id="villeManuelle" class="form-control" placeholder="Tapez le nom d'une ville">
      </div>

      <!-- Carte -->
      <div id="selectionCarte" class="mb-3" style="display: none;">
        <div id="carte"></div>
      </div>

      <!-- Message info -->
      <div id="messageInfo" class="alert alert-info mt-2" style="display: none;"></div>

      <!-- Champ caché pour la ville -->
      <input type="hidden" name="ville" id="villeFinale" required>

      <button type="submit" class="btn btn-warning mt-3">Rechercher</button>
      <button type="reset" class="btn btn-secondary mt-3">Annuler</button>
    </form>
  </div>

  <script>
    const villes = {
      "aix-en-provence": { nom: "Aix-en-Provence", lat: 43.5297, lon: 5.4474 },
      "bordeaux": { nom: "Bordeaux", lat: 44.8378, lon: -0.5792 },
      "idf": { nom: "Île-de-France", lat: 48.8499, lon: 2.6370 },
      "lille": { nom: "Lille", lat: 50.6292, lon: 3.0573 },
      "lyon": { nom: "Lyon", lat: 45.75, lon: 4.85 },
      "marseille": { nom: "Marseille", lat: 43.2965, lon: 5.3698 },
      "montpellier": { nom: "Montpellier", lat: 43.6119, lon: 3.8777 },
      "nantes": { nom: "Nantes", lat: 47.2184, lon: -1.5536 },
      "paris": { nom: "Paris", lat: 48.8566, lon: 2.3522 },
      "reims": { nom: "Reims", lat: 49.2583, lon: 4.0317 },
      "rennes": { nom: "Rennes", lat: 48.1173, lon: -1.6778 },
      "strasbourg": { nom: "Strasbourg", lat: 48.5734, lon: 7.7521 },
      "toulouse": { nom: "Toulouse", lat: 43.6047, lon: 1.4442 }
    };

    const map = L.map('carte').setView([46.6, 2.2], 6);
    const markerGroup = L.layerGroup().addTo(map);

    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap',
      minZoom: 3,
      maxZoom: 18
    }).addTo(map);

    // Marqueurs visibles dès le chargement
    for (const key in villes) {
      const ville = villes[key];
      const marker = L.marker([ville.lat, ville.lon])
        .bindPopup(ville.nom)
        .addTo(markerGroup);

      marker.on('click', () => {
        document.getElementById('villeFinale').value = ville.nom;
      });
    }

    // Geocoder
    L.Control.geocoder({
      defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
      const latlng = e.geocode.center;
      map.setView(latlng, 12);
      L.marker(latlng).addTo(markerGroup).bindPopup(e.geocode.name).openPopup();
      document.getElementById('villeFinale').value = e.geocode.name;
    })
    .addTo(map);

    // Contrôle affichage selon mode sélectionné
    const modeSelect = document.getElementById('mode');
    const divManuelle = document.getElementById('selectionManuelle');
    const divCarte = document.getElementById('selectionCarte');
    const villeManuelle = document.getElementById('villeManuelle');
    const villeFinale = document.getElementById('villeFinale');
    const messageInfo = document.getElementById('messageInfo');

    modeSelect.addEventListener("change", function () {
      const mode = modeSelect.value;
      villeFinale.value = "";
      messageInfo.style.display = "none";

      if (mode === "manuel") {
        divManuelle.style.display = "block";
        divCarte.style.display = "none";
      } else if (mode === "carte") {
        divManuelle.style.display = "none";
        divCarte.style.display = "block";
        map.invalidateSize(); // corrige l'affichage après apparition
        map.setView([46.6, 2.2], 6); // réinitialiser la vue avec tous les marqueurs
      } else if (mode === "toutes") {
        divManuelle.style.display = "none";
        divCarte.style.display = "none";
        villeFinale.value = "toutes";
        messageInfo.innerText = "Recherche sur toutes les villes.";
        messageInfo.style.display = "block";
      }
    });

    // Saisie manuelle
    villeManuelle.addEventListener("input", function () {
      villeFinale.value = villeManuelle.value;
    });
  </script>
</body>
</html>
