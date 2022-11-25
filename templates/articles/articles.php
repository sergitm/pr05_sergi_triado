<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/

// Creem l'objecte per fer peticions
include "model/http.request.php";

$http = new HttpRequest("environment/environment.json");
$environment = $http->getEnvironment();

// Si hi ha un article introduït per POST fem l'insert a la BBDD abans de mostrar els articles

if(!empty($_POST['insertArticle']) && !empty($_POST['article'])){
    $insertUrl = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->article->create;

    $article = $_POST['article'];
    $insertData = array('article' => $article, 'autor' => $_SESSION['username']);

    $insertResult = $http->makePostRequest($insertUrl, $insertData);

    if ($insertResult != null) {
        if(isset($insertResult->success)){
            header("Location: " . $environment->protocol . $environment->baseUrl);
        } else {
            $insert = false;
        }
    } else {
        $insert = false;
    }
}

// Establim el numero de pagina en la que l'usuari es troba.
# si no troba cap valor, assignem la pagina 1.
$pagina = (empty($_GET['pagina'])) ? 1 : intval($_GET['pagina']);

// definim quants post per pagina volem carregar.

$post_per_pag = (!empty($_GET['post_x_pag']) && (intval($_GET['post_x_pag']) > 0)) ? intval($_GET['post_x_pag']) : 5;

// Revisem des de quin article anem a carregar, depenent de la pagina on es trobi l'usuari.
# Comprovem si la pagina en la que es troba es més gran d'1, sino carreguem des de l'article 0.
# Si la pagina es més gran que 1, farem un càlcul per saber des de quin post carreguem

$primer_article = ($pagina > 1) ? ($pagina - 1) * $post_per_pag : 0;

// Fem la petició HTTP al backend per rebre els articles

$url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->article->read;

$data = array('offset' => $primer_article, 'row_count' => $post_per_pag);

# Si l'usuari està loguejat, incluïm el seu nom d'usuari a la petició per rebre els SEUS articles

if (isset($_SESSION['username'])) {
    $data['username'] = $_SESSION['username'];
}

# Fem la petició i rebem les dades

$result = $http->makePostRequest($url, $data);

if ($result != null) {
    $num = count($result->articles);
} else {
    $num = 0;
}

// Calculem el total d'articles per a poder conèixer el número de pàgines de la paginació
$quantitat = $result->count;

// Calculem el numero de pagines que tindrà la paginació. Llavors hem de dividir el total d'articles entre els POSTS per pagina

$maxim_pagines = ($quantitat % $post_per_pag > 0) ? floor($quantitat / $post_per_pag + 1) : floor($quantitat / $post_per_pag);

// Incluim la vista

require 'templates/articles/articles.vista.php';

?>