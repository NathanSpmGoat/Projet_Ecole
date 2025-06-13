<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
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
      color: #fff;
    }
    #carte {
      height: 500px;
      margin-top: 20px;
    }
    .hidden {
      display: none;
    }
  </style>
</head>
<body>
<div class="container mt-4">
  <form id="formRecherche" action="Etablissement.php" method="post">
    <fieldset>
      <!-- Domaine -->
      <div class="mb-3">
        <label for="domaine">Domaine souhaité</label>
        <select id="domaine" name="domaine" class="form-select" required>
          <option value="" disabled selected>Cliquez pour choisir un domaine</option>
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

      <!-- Choix du mode -->
      <div class="mb-3">
        <label>Choisir la méthode de sélection :</label>
        <div>
          <input type="radio" id="modeSelect" name="modeSelection" value="select" checked />
          <label for="modeSelect">Sélectionner une ville dans la liste</label>
        </div>
        <div>
          <input type="radio" id="modeCarte" name="modeSelection" value="carte" />
          <label for="modeCarte">Choisir une ville sur la carte</label>
        </div>
      </div>

      <!-- Select des villes -->
      <div class="mb-3" id="containerSelectVille">
        <label for="villeSelect">Ville</label>
        <select id="villeSelect" name="ville" class="form-select" required>
          <option value="" disabled selected>Choisissez une ville</option>
          <option value="toutes">Toutes les villes</option>
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

      <!-- Carte + input caché -->
      <div id="containerCarte" class="hidden">
        <label for="villeCarte">Ville sélectionnée sur la carte</label>
        <input type="text" id="villeCarte" name="ville" class="form-control mb-3" readonly placeholder="Cliquez sur la carte ou utilisez la recherche" required />
        <div id="carte"></div>
      </div>

      <div class="mt-3">
        <button type="submit" class="btn btn-warning">Rechercher</button>
        <button type="reset" class="btn btn-secondary" id="btnReset">Annuler</button>
      </div>
    </fieldset>
  </form>

  <div id="messageSelection" class="mt-3"></div>
</div>

<script>
  const villes = {
    "Aix-en-Provence": { lat: 43.5297, lon: 5.4474 },
    "Bordeaux": { lat: 44.8378, lon: -0.5792 },
    "Île-de-France": { lat: 48.8499, lon: 2.6370 },
    "Lille": { lat: 50.6292, lon: 3.0573 },
    "Lyon": { lat: 45.75, lon: 4.85 },
    "Marseille": { lat: 43.2965, lon: 5.3698 },
    "Montpellier": { lat: 43.6119, lon: 3.8777 },
    "Nantes": { lat: 47.2184, lon: -1.5536 },
    "Paris": { lat: 48.8566, lon: 2.3522 },
    "Reims": { lat: 49.2583, lon: 4.0317 },
    "Rennes": { lat: 48.1173, lon: -1.6778 },
    "Strasbourg": { lat: 48.5734, lon: 7.7521 },
    "Toulouse": { lat: 43.6047, lon: 1.4442 }
  };

  // Elements DOM
  const modeSelect = document.getElementById('modeSelect');
  const modeCarte = document.getElementById('modeCarte');
  const containerSelectVille = document.getElementById('containerSelectVille');
  const containerCarte = document.getElementById('containerCarte');
  const villeSelect = document.getElementById('villeSelect');
  const villeCarteInput = document.getElementById('villeCarte');
  const messageSelection = document.getElementById('messageSelection');
  const form = document.getElementById('formRecherche');
  const btnReset = document.getElementById('btnReset');

  // Gestion affichage selon mode choisi
  function toggleMode() {
    if (modeSelect.checked) {
      containerSelectVille.classList.remove('hidden');
      containerCarte.classList.add('hidden');
      villeCarteInput.value = '';
      messageSelection.textContent = '';
    } else {
      containerSelectVille.classList.add('hidden');
      containerCarte.classList.remove('hidden');
      villeSelect.value = '';
      messageSelection.textContent = '';
      map.invalidateSize(); // Pour forcer Leaflet à redimensionner la carte si besoin
    }
  }

  modeSelect.addEventListener('change', toggleMode);
  modeCarte.addEventListener('change', toggleMode);

  // Initialisation carte
  const map = L.map('carte').setView([46.6, 2.2], 6);
  const markerGroup = L.layerGroup().addTo(map);

  L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap',
    minZoom: 3,
    maxZoom: 18
  }).addTo(map);

  // Affichage de tous les marqueurs dès le départ
  for (const nom in villes) {
    const ville = villes[nom];
    const marker = L.marker([ville.lat, ville.lon]).addTo(markerGroup).bindPopup(nom);

    marker.on('click', () => {
      villeCarteInput.value = nom;
      afficherMessageSelection(nom);
    });
  }

  // Recherche sur la carte
  L.Control.geocoder({
    defaultMarkGeocode: false
  })
  .on('markgeocode', function(e) {
    const latlng = e.geocode.center;
    map.setView(latlng, 12);

    // Supprimer les anciens marqueurs placés via recherche (mais pas les villes fixes)
    markerGroup.clearLayers();

    // On re-ajoute les marqueurs fixes
    for (const nom in villes) {
      const ville = villes[nom];
      L.marker([ville.lat, ville.lon]).addTo(markerGroup).bindPopup(nom);
    }

    // Marqueur pour le résultat de la recherche
    const marker = L.marker(latlng).addTo(markerGroup).bindPopup(e.geocode.name).openPopup();

    villeCarteInput.value = e.geocode.name;
    afficherMessageSelection(e.geocode.name);
  })
  .addTo(map);

  // Gestion message de sélection
  function afficherMessageSelection(ville) {
    if (!ville) {
      messageSelection.textContent = '';
      return;
    }

    if (ville.toLowerCase() === 'toutes les villes' || ville.toLowerCase() === 'toutes') {
      messageSelection.textContent = 'Vous avez sélectionné toutes les villes.';
    } else {
      messageSelection.textContent = 'Vous avez sélectionné : ' + ville;
    }
  }

  // Quand on change la sélection dans le select ville
  villeSelect.addEventListener('change', () => {
    afficherMessageSelection(villeSelect.value);
  });

  // Quand on reset le formulaire
  btnReset.addEventListener('click', () => {
    messageSelection.textContent = '';
    villeCarteInput.value = '';
    villeSelect.value = '';
  });

  // Initialisation de l'affichage mode
  toggleMode();
</script>
</body>
</html>
