<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez que les champs 'title' et 'description' sont présents dans la requête POST
    if (isset($_POST['title']) && isset($_POST['description'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        echo "Title: " . htmlspecialchars($title) . "<br>";
        echo "Description: " . htmlspecialchars($description) . "<br>";

        // Remplacez par votre access token de la page Facebook
        $pageAccessToken = 'EAAFFsZADJq0kBO25iV1EUZBh3Wp3xsOoWx394IXsl74BQTtWXlZCOaZArLIIRnO6tNTDO0SZC9JXLxMRK0skU9YpkAz2BEy8VxgTum7x2keJZCnSX52b1ZBJzrbiWfK6MXzU2ZA8Oq7kH4pGRKm3HCJu1MhVMBZAuoZBxgZBoSIiIqhto1OsZAEPTqFvTkfZChwZDZD';
        // Remplacez par l'ID de votre page Facebook
        $pageId = '358103917374281';

        // L'URL de l'API Graph pour publier sur la page Facebook
        $url = "https://graph.facebook.com/v17.0/$pageId/feed";

        // Le message à publier
        $data = [
            'message' => "$title\n\n$description",
            'access_token' => $pageAccessToken
        ];

        // Initialiser une requête cURL pour envoyer une requête POST à l'API Graph
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Assurez-vous que le chemin du fichier cacert.pem est correct
        curl_setopt($ch, CURLOPT_CAINFO, 'C:/wamp64/bin/php/php8.2.0/extras/ssl/cacert.pem');

        // Exécuter la requête et capturer la réponse
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Erreur cURL: ' . curl_error($ch);
        } else {
            echo 'Réponse de l\'API: ' . htmlspecialchars($response);
        }
        curl_close($ch);

        // Décoder la réponse JSON
        $result = json_decode($response, true);

        // Vérifiez si la publication a été réussie
        if (isset($result['id'])) {
            echo "Publication réussie sur Facebook !";
        } else {
            echo "Erreur lors de la publication : " . htmlspecialchars($response);
        }
    } else {
        echo "Les champs 'title' et 'description' sont requis.";
    }
} else {
    echo "Méthode de requête non supportée";
}
?>
