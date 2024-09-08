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

        <div id="message"></div>

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

       function showMessage(message, type = 'success') {
            const messageDiv = document.getElementById('message');
            messageDiv.style.display = 'block';
            messageDiv.innerHTML = message;

            if (type === 'error') {
                messageDiv.style.background = 'red';
            } else {
                messageDiv.style.background = 'green';
            }

            // Masquer le message après 2 secondes (2000 millisecondes)
            setTimeout(function() {
                messageDiv.style.display = 'none';
            }, 2000);
        }

        function fbLogin() {
            FB.login(function(response) {
                if (response.status === 'connected') {
                    document.getElementById('publicationForm').classList.remove('hidden');
                    document.getElementById('fbLoginButton').classList.add('hidden');
                    console.log('Connexion réussie!');
                } else {
                    console.log('Erreur de connexion. Veuillez réessayer.', 'error');
                }
            }, {scope: 'public_profile,email'});
        }

      function shareOnFacebook() {
          const title = document.getElementById('title').value;
          const description = document.getElementById('description').value;

          if (!title || !description) {
              showMessage('Veuillez remplir tous les champs avant de publier.', 'error');
              return;
          }

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
          .then(response => {
              if (!response.ok) {
                  throw new Error('Une erreur s\'est produite lors de la publication.');
              }
              return response.text();
          })
          .then(data => {
              showMessage('Publication réussie sur Facebook !', 'success');
              console.log(data);
          })
          .catch(error => {
              showMessage(error.message, 'error');
              console.error('Erreur:', error);
          });
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