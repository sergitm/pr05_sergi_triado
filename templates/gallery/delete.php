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
                $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->imatge->delete;
                $data = array('id' => $value);

                $result = $http->makePostRequest($url, $data);

                if ($result != null && isset($result->success)) {
                    header("Location: " . $environment->protocol . $environment->baseUrl . "templates/gallery/gallery.php");
                } else {
                    print "<h1 class='text-danger' style='text-align:center'>Hi ha hagut un error al eliminar</h1>";
                    header("refresh:1;url=" . $environment->protocol . $environment->baseUrl . "templates/gallery/gallery.php");
                }
            }
        }
    } else {
        header("Location : " . $environment->protocol . $environment->baseUrl);
    }
?>