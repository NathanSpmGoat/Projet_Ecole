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
      margin-top: 20px;
    }
    #zone-select, #zone-carte {
      display: none;
    }
  </style>
</head>

<body>
<div class="container mt-4">
  <h1 class="mb-4">Mes recommandations</h1>
  <form action="Etablissement.php" method="post">
    <fieldset>
      <!-- Domaine -->
      <div class="mb-3">
        <label for="domaine" class="form-label">Domaine souhaité</label>
        <select id="domaine" name="domaine" class="form-select" required>
          <option value="" selected disabled>Choisissez un domaine</option>
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

      <!-- Choix de la méthode -->
      <div class="mb-3">
        <label for="choix-methode" class="form-label">Méthode de sélection de la ville</label>
        <select id="choix-methode" class="form-select" required>
          <option value="" selected disabled>Choisissez une méthode</option>
          <option value="select">Sélection via liste déroulante</option>
          <option value="carte">Utiliser la carte interactive</option>
        </select>
      </div>

      <!-- Sélection manuelle -->
      <div id="zone-select" class="mb-3">
        <label for="ville" class="form-label">Ville</label>
        <select id="ville-select" class="form-select">
          <option value="" selected disabled>Choisissez une ville</option>
          <option value="all">Toutes les villes</option>
          <option value="Paris">Paris</option>
          <option value="Lyon">Lyon</option>
          <option value="Marseille">Marseille</option>
          <option value="Lille">Lille</option>
          <option value="Toulouse">Toulouse</option>
          <option value="Strasbourg">Strasbourg</option>
          <option value="Bordeaux">Bordeaux</option>
          <option value="Nantes">Nantes</option>
          <option value="Montpellier">Montpellier</option>
          <option value="Rennes">Rennes</option>
          <option value="Reims">Reims</option>
          <option value="Aix-en-Provence">Aix-en-Provence</option>
          <option value="Île-de-France">Île-de-France</option>
        </select>
      </div>

      <!-- Carte interactive -->
      <div id="zone-carte">
        <label class="form-label">Ville sélectionnée :</label>
        <input type="text" id="ville" name="ville" class="form-control mb-2" readonly required placeholder="Choisissez une ville via la carte ou la barre de recherche" />
        <div id="carte"></div>
      </div>

      <!-- Message dynamique -->
      <div id="message" class="mt-2 fw-bold text-warning"></div>

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

  const map = L.map('carte').setView([46.6, 2.2], 6);
  const markerGroup = L.layerGroup().addTo(map);
  L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap',
    minZoom: 3,
    maxZoom: 18
  }).addTo(map);

  // Marqueurs sur la carte
  for (const key in villes) {
    const ville = villes[key];
    const marker = L.marker([ville.lat, ville.lon])
      .bindPopup(ville.nom)
      .addTo(markerGroup);
    marker.on('click', () => {
      document.getElementById('ville').value = ville.nom;
      document.getElementById('message').textContent = '';
    });
  }

  // Recherche sur la carte
  L.Control.geocoder({
    defaultMarkGeocode: false
  })
    .on('markgeocode', function (e) {
      const latlng = e.geocode.center;
      map.setView(latlng, 12);
      L.marker(latlng).addTo(markerGroup).bindPopup(e.geocode.name).openPopup();
      document.getElementById('ville').value = e.geocode.name;
      document.getElementById('message').textContent = '';
    })
    .addTo(map);

  // Choix de la méthode
  document.getElementById('choix-methode').addEventListener('change', function () {
    const methode = this.value;
    document.getElementById('zone-select').style.display = methode === 'select' ? 'block' : 'none';
    document.getElementById('zone-carte').style.display = methode === 'carte' ? 'block' : 'none';
    document.getElementById('message').textContent = '';
    document.getElementById('ville').value = '';
    if (methode === 'carte') {
      setTimeout(() => map.invalidateSize(), 100);
    }
  });

  // Message spécial pour "Toutes les villes"
  document.getElementById('ville-select').addEventListener('change', function () {
    const ville = this.value;
    document.getElementById('ville').value = ville === 'all' ? '' : ville;
    document.getElementById('message').textContent =
      ville === 'all' ? 'Vous avez sélectionné toutes les villes.' : '';
  });

  // Réinitialiser le message et les champs
  document.querySelector('form').addEventListener('reset', function () {
    setTimeout(() => {
      document.getElementById('ville').value = '';
      document.getElementById('message').textContent = '';
      document.getElementById('zone-select').style.display = 'none';
      document.getElementById('zone-carte').style.display = 'none';
      document.getElementById('choix-methode').selectedIndex = 0;
    }, 100);
  });
</script>
</body>
</html>
