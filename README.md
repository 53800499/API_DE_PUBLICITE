# Facebook Publication API

Ce projet est un exemple d'intégration d'un formulaire permettant la publication automatique de contenu sur une page Facebook. L'authentification est gérée via l'API Facebook en JavaScript, et la publication des posts sur la page Facebook est effectuée avec PHP en utilisant l'API Graph de Facebook.

## Fonctionnalités
- Authentification via Facebook.
- Publication de contenu sur une page Facebook via un formulaire HTML.
- Envoi de données via JavaScript au backend en PHP pour traitement.
- Utilisation de cURL pour interagir avec l'API Graph de Facebook et publier des posts.

## Prérequis
- Un compte développeur Facebook.
- Une application Facebook (App ID et App Secret).
- Un token d'accès à la page Facebook.
- Serveur local ou serveur en ligne pour exécuter du PHP.
- Utilisation de ngrok (ou similaire) pour exposer l'application localement si nécessaire.
- Node.js (version >= 14).

## Installation

### Étape 1: Installer ngrok
Si vous utilisez Windows, vous pouvez installer ngrok via Chocolatey :
```bash
choco install ngrok
```
Ou téléchargez-le directement depuis [ngrok](https://ngrok.com/download).

### Étape 2: Cloner le projet
```bash
git clone https://github.com/53800499/API_DE_PUBLICITE.git
cd API_DE_PUBLICITE
```

### Étape 3: Configurer votre application Facebook
1. Créez une application sur [Facebook for Developers](https://developers.facebook.com/).
2. Activez **Facebook Login** pour Web, et définissez l'URL de redirection OAuth.
3. Obtenez votre **App ID** et **Page Access Token** et configurez-les dans le code du projet (`index.php` et `api.php`).

### Étape 4: Configurer ngrok (si nécessaire)
Si vous travaillez en local et devez tester avec Facebook, exposez votre serveur avec ngrok :
```bash
ngrok http 8000
```
Copiez l'URL générée par ngrok et ajoutez-la dans les **URI de redirection OAuth** sur Facebook Developers.

### Étape 5: Exécuter le serveur local
Si vous utilisez un serveur local comme WAMP, XAMPP, ou MAMP, placez le projet dans le répertoire `www` ou `htdocs`, puis lancez le serveur et accédez au projet via `http://localhost:8000`.

### Étape 6: Tester l'application
1. Ouvrez votre navigateur et accédez à l'URL de votre projet.
2. Connectez-vous via Facebook en utilisant le bouton de connexion.
3. Remplissez le formulaire avec le titre et la description, puis cliquez sur "Partager sur Facebook" pour publier sur la page.
