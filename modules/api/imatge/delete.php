<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
require_once "../../config/database.php";
require_once "../../control/image_manager.php";
require_once "../../control/control_usuaris.php";
require_once "../../../model/imatge.php";
require_once "../../../model/user.php";

// $data = json_decode(file_get_contents("php://input"));

if (!empty($_POST['id'])) {
    $result = ImageManager::delete_image($_POST['id']);

    if ($result) {
        $missatge = array('success' => true);
    } else {
        $missatge = array('error' => true);
    }
}

echo json_encode($missatge);
?>