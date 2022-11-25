<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
require_once '../../../public/lib/OAuth2/vendor/autoload.php';
include "../../../model/http.request.php";

$http = new HttpRequest("../../../environment/environment.json");
$environment = $http->getEnvironment();

$client = new Google\Client();
$client->setAuthConfig('../../../public/lib/OAuth2/client_credentials.json');

$client->addScope(Google\Service\Drive::DRIVE);

$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$client->setRedirectUri($redirect_uri);
$service = new Google\Service\Drive($client);

if (isset($_REQUEST['logout'])) {
    unset($_SESSION['upload_token']);
}

if (isset($_GET['code'])) {

    print("<h1 style='color:red;text-align:center'>El codi de l'autenticació està comentat perquè sense certificat SSL, OAuth2 no em deixa generar un token.</h1>");
    print("<form><button type='submit' formaction='../../../'>Tornar</button></form>");

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    // $client->setAccessToken($token);

    $_SESSION['upload_token'] = $token;
}


if (empty($_SESSION['upload_token'])) {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
} 
?>