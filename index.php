<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);
session_start();

$env = json_decode(file_get_contents("environment/environment.json"));
$environment = $env->environment;

define('BASE_URL', $environment->protocol . $environment->baseUrl);

// Barra de navegació 

include "public/navbar.php";

// Controlador d'articles

include "templates/articles/articles.php";

?>