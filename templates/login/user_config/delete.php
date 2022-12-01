
<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    include "../../../model/http.request.php";

    $http = new HttpRequest("../../../environment/environment.json");
    $environment = $http->getEnvironment();

    if (!empty($_POST)) {
        $keys = array_keys($_POST);
        foreach ($keys as $value) {
            if (is_int($value)) {
                $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->usuari->delete;
                $data = array('id' => $value);

                $result = $http->makePostRequest($url, $data);
                var_dump($result);
                if ($result != null && isset($result->success)) {
                    setcookie(session_name(),'',0,'/');
                    session_destroy();
                    session_write_close();

                    header("Location: " . $environment->protocol . $environment->baseUrl);
                }
            }
        }
    } else {
        header("Location: " . $environment->protocol . $environment->baseUrl);
    }
?>