<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    include "../../model/http.request.php";

    $http = new HttpRequest("../../environment/environment.json");
    $environment = $http->getEnvironment();

    if (!empty($_POST)) {
        $keys = array_keys($_POST);
        foreach ($keys as $value) {
            if (is_int($value)) {

                $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->article->read;
                $data = array('id' => $value);

                $result = $http->makePostRequest($url, $data);
                if ($result != null && isset($result->article)) {
                    $article = $result->article;
                    include "update.view.php";
                } else {
                    print "<h1 class='text-danger' style='text-align:center'>No existeix el post</h1>";
                    header("refresh:1;url=" . $environment->protocol . $environment->baseUrl);
                }
            }
        }
    } else {
        header("Location: " . $environment->protocol . $environment->baseUrl);
    }

    
    if (isset($_POST['newArticle']) && isset($_POST['updateArticle']) && !empty($_POST['newArticle']) ) {
                        
        $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->article->update;
        $data = array('id' => $_POST['id'], 'article' => $_POST['newArticle']);

        $result = $http->makePostRequest($url, $data);
        
        if ($result != null && isset($result->success)) {
            header("Location: " . $environment->protocol . $environment->baseUrl);
        } else {
            print "<h1 class='text-danger' style='text-align:center'>Hi ha hagut un error al actualitzar l'article</h1>";
            header("refresh:1;url=" . $environment->protocol . $environment->baseUrl);
        }
    }
    
?>