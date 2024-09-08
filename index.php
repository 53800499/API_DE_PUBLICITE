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
    <meta property="og:title" content="<?php echo htmlspecialchars($title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($description); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($pageUrl); ?>">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
<div class="container">
        <h1>Publier sur Facebook</h1>
        <!-- Bouton pour se connecter avec Facebook -->
        <button id="fbLoginButton" onclick="fbLogin()">Se connecter avec Facebook</button>

        <!-- Formulaire de publication -->
        <form id="publicationForm" class="hidden" method="POST" action="api.php">
            <label for="title">Titre:</label>
            <input type="text" id="title" name="title" placeholder="Entrez le titre" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" placeholder="Entrez la description" required></textarea>

            <button type="button" onclick="shareOnFacebook()">Partager sur Facebook</button>
        </form>
    </div>

    <!-- SDK Facebook et script JavaScript -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '358103917374281',  // Remplacez par votre App ID
          cookie     : true,           
          xfbml      : true,           
          version    : 'v16.0'         
        });

        FB.AppEvents.logPageView();   

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
            document.getElementById('publicationForm').classList.remove('hidden');
            document.getElementById('publicationForm').classList.add('visible');
            document.getElementById('fbLoginButton').classList.add('hidden');
            console.log('Utilisateur connecté');
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
          document.getElementById('publicationForm').classList.remove('hidden');
          document.getElementById('publicationForm').classList.add('visible');
          document.getElementById('fbLoginButton').classList.add('hidden');
        } else {
          document.getElementById('publicationForm').classList.add('hidden');
        }
      }
    </script>
</body>
</html>