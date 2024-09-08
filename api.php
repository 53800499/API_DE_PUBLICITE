<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    echo $title, $description;

    // Remplacez par votre access token de la page Facebook
    $pageAccessToken = 'EAAL2XJV9bcoBO6Ow9fDfWV2JigUDErpcZBkmoxiffeHLbVDnaS6zjqFbOhD5hZBpXup9ebv7lJgnbw6sXyaXTBqZCVextHUfmTpsKuu6RovphYZALVWtqZARX5eJTWtVompTgZBZBbf6WWE2TZAtdlEYXUQi2ZAWWjk8fwtXRtO9Wz7vIfUaTDzOuJRVib3kEH5qCQ7HnJm0RO57d6G7GsH0y5OWidGoTD3SNqZB8dWM32CQ7XZBZA7qhI8ZC6BMW5sm33AZDZD';
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

    // Exécuter la requête et capturer la réponse
    $response = curl_exec($ch);
    curl_close($ch);

    // Décoder la réponse JSON
    $result = json_decode($response, true);

    // Vérifiez si la publication a été réussie
    if (isset($result['id'])) {
        echo "Publication réussie sur Facebook !";
    } else {
        echo "Erreur lors de la publication : " . $response;
    }
} else {
    echo "Méthode de requête non supportée";
}
?>
