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

            $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->imatge->read;
            $data = array('id' => $value);

            $result = $http->makePostRequest($url, $data);
            if ($result != null && isset($result->imatge)) {
                $imatge = $result->imatge;
                $img_name = pathinfo($imatge->path,PATHINFO_FILENAME);
                $img_path = pathinfo($imatge->path,PATHINFO_DIRNAME);
                $img_ext = pathinfo($imatge->path,PATHINFO_EXTENSION);
                include "update.view.php";
            } else {
                header("refresh:1;url=" . $environment->protocol . $environment->baseUrl);
                print "<h1 class='text-danger' style='text-align:center'>No existeix la imatge</h1>";
            }
        }
    }
} else {
    header("Location: " . $environment->protocol . $environment->baseUrl);
}

// Si s'ha canviat el nom, enviem petició al backend per actualitzar
if (isset($_POST['newName']) && isset($_POST['updateName']) && !empty($_POST['newName'])) {

    $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->imatge->update;

    $data = array(
        'id' => $_POST['id'], 
        'newPath' => $_POST['path'] . $_POST['newName'] . '.' . $_POST['extension']
    );
    $og_path = "../../" . $_POST['path'] . $_POST['name'] . '.' . $_POST['extension'];

    $result = $http->makePostRequest($url, $data);

    if ($result != null && isset($result->success)) {
        if (rename($og_path, "../../" . $data['newPath'])) {
            header("Location: " . $environment->protocol . $environment->baseUrl . "templates/gallery/gallery.php");
        }
    } else {
        header("refresh:1;url=" . $environment->protocol . $environment->baseUrl . "templates/gallery/gallery.php");
        print "<h1 class='text-danger' style='text-align:center'>Hi ha hagut un error al actualitzar el nom de la imatge</h1>";
    }


}
?>