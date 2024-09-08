<?php
$title = "Titre dynamique de la Page"; // Par exemple, récupérer depuis une base de données
$description = "Description dynamique de la Page"; // Récupérer également depuis une base de données
$pageUrl = "https://7c78-41-85-163-249.ngrok-free.app"; // L'URL canonique de la page
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    
    <!-- Balises Open Graph pour le partage sur les réseaux sociaux -->
    <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($description); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($pageUrl); ?>">
    
    <!-- Autres balises meta, styles, et scripts -->
</head>
<body>
    <!-- Bouton pour se connecter avec Facebook -->
    <button onclick="fbLogin()">Se connecter avec Facebook</button>

    <!-- Formulaire de publication -->
    <form id="publicationForm" style="display: none;" method="POST" action="api.php">
        <label for="title">Titre:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <button type="button" onclick="shareOnFacebook()">Partager sur Facebook</button>
    </form>

    <!-- SDK Facebook pour la connexion -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '358103917374281',  // Remplacez par votre App ID
          cookie     : true,           // Active l'utilisation des cookies
          xfbml      : true,           // Active le parsing des plugins sociaux
          version    : 'v16.0'         // Version actuelle de l'API Graph
        });

        FB.AppEvents.logPageView();   // Enregistre une vue de la page

        // Vérifie l'état de connexion lors du chargement
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "https://connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));

      // Fonction de connexion Facebook
      function fbLogin() {
        FB.login(function(response) {
          if (response.status === 'connected') {
            // L'utilisateur est connecté, afficher le formulaire
            document.getElementById('publicationForm').style.display = 'block';
            console.log('Utilisateur connecté', response);
          } else {
            console.log('Utilisateur non connecté');
          }
        }, {scope: 'public_profile,email'});
      }

      // Fonction pour partager le post sur Facebook
      function shareOnFacebook() {
        const title = document.getElementById('title').value;
        const description = document.getElementById('description').value;

        fetch('api.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({
            'title': title,
            'description': description
          })
        })
        .then(response => response.text())
        .then(data => console.log(data))
        .catch(error => console.error('Erreur:', error));
      }


      // Fonction de rappel pour vérifier l'état de connexion
      function statusChangeCallback(response) {
        if (response.status === 'connected') {
          document.getElementById('publicationForm').style.display = 'block';
        } else {
          document.getElementById('publicationForm').style.display = 'none';
        }
      }
    </script>
</body>
</html>
