<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mes recommandations</title>

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
      color: #ffffff;
    }

    #carte {
      height: 500px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <form action="Etablissement.php" method="post">
    <fieldset>
      <!-- Domaine -->
      <div class="mb-3">
        <label for="domaine">Domaine souhaité</label>
        <select id="domaine" name="domaine" class="form-select form-select-lg mb-3" required>
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
        <label for="modeSelection">Mode de sélection de la ville :</label>
        <select id="modeSelection" class="form-select">
          <option value="manuel" selected>Liste déroulante</option>
          <option value="carte">Carte interactive</option>
        </select>
      </div>

      <!-- Sélection manuelle -->
      <div id="selectionManuelle">
        <label for="villeManuelle">Ville (liste déroulante)</label>
        <select id="villeManuelle" class="form-select form-select-lg mb-3">
          <option value="" selected disabled>Cliquez pour choisir une ville</option>
          <option value="all">Toutes les villes</option>
          <option value="Aix-en-Provence">Aix-en-Provence</option>
          <option value="Bordeaux">Bordeaux</option>
          <option value="Île-de-France">Île-de-France</option>
          <option value="Lille">Lille</option>
          <option value="Lyon">Lyon</option>
          <option value="Marseille">Marseille</option>
          <option value="Montpellier">Montpellier</option>
          <option value="Nantes">Nantes</option>
          <option value="Paris">Paris</option>
          <option value="Reims">Reims</option>
          <option value="Rennes">Rennes</option>
          <option value="Strasbourg">Strasbourg</option>
          <option value="Toulouse">Toulouse</option>
        </select>
      </div>

      <!-- Sélection via carte -->
      <div id="selectionCarte" style="display:none;">
        <label for="villeCarte">Ville sélectionnée :</label>
        <input type="text" id="villeCarte" class="form-control form-control-lg mb-2" readonly placeholder="Choisissez une ville sur la carte ou via recherche" />
        <button type="button" id="btnAllVilles" class="btn btn-outline-light mb-2">Sélectionner toutes les villes</button>
        <div id="carte"></div>
      </div>

      <!-- Champ caché transmis au serveur -->
      <input type="hidden" name="ville" id="villeFinale" required />

      <!-- Boutons -->
      <div class="mt-4">
        <button type="submit" class="btn btn-warning">Rechercher</button>
        <button type="reset" class="btn btn-secondary">Annuler</button>
      </div>
    </fieldset>
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

  const modeSelect = document.getElementById('modeSelection');
  const divManuelle = document.getElementById('selectionManuelle');
  const divCarte = document.getElementById('selectionCarte');
  const villeManuelle = document.getElementById('villeManuelle');
  const villeCarte = document.getElementById('villeCarte');
  const villeFinale = document.getElementById('villeFinale');
  const btnAllVilles = document.getElementById('btnAllVilles');

  // Mode de sélection : liste ou carte
  modeSelect.addEventListener('change', function () {
    if (this.value === 'manuel') {
      divManuelle.style.display = 'block';
      divCarte.style.display = 'none';
      villeFinale.value = villeManuelle.value;
    } else {
      divManuelle.style.display = 'none';
      divCarte.style.display = 'block';
      villeFinale.value = villeCarte.value;
    }
  });

  // Mise à jour automatique ville finale selon la sélection manuelle
  villeManuelle.addEventListener('change', function () {
    villeFinale.value = this.value;
  });

  // Bouton "toutes les villes"
  btnAllVilles.addEventListener('click', function () {
    villeCarte.value = "Toutes les villes";
    villeFinale.value = "all";
  });

  // Carte Leaflet
  const map = L.map('carte').setView([46.6, 2.2], 6);
  L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap',
    minZoom: 3,
    maxZoom: 18
  }).addTo(map);

  const markerGroup = L.layerGroup().addTo(map);

  for (const key in villes) {
    const ville = villes[key];
    const marker = L.marker([ville.lat, ville.lon])
      .bindPopup(ville.nom)
      .addTo(markerGroup);

    marker.on('click', () => {
      villeCarte.value = ville.nom;
      villeFinale.value = ville.nom;
    });
  }

  L.Control.geocoder({
    defaultMarkGeocode: false
  })
  .on('markgeocode', function (e) {
    const latlng = e.geocode.center;
    map.setView(latlng, 12);
    L.marker(latlng).addTo(markerGroup).bindPopup(e.geocode.name).openPopup();
    villeCarte.value = e.geocode.name;
    villeFinale.value = e.geocode.name;
  })
  .addTo(map);
</script>
</body>
</html>
