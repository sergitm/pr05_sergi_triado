<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, X-Requested-With');
    header('Content-Type: application/json');

    require_once "../../config/database.php";
    require_once "../../../model/user.php";
    require_once "../../../model/imatge.php";
    require_once "../../control/control_usuaris.php";
    require_once "../../control/image_manager.php";

    // $data = json_decode(file_get_contents("php://input"));

    if (!empty($_POST['path']) && !empty($_POST['username'])) {
        if (ImageManager::upload_image($_POST['path'],$_POST['username'])) {

            $missatge = array('status' => 'OK', 'message' => 'Imatge penjada satisfactoriament');
        } else {
            $missatge = array( 'status' => "ERROR", 'message' => 'Hi ha hagut un error a la base de dades');
        }
    } else {
        $missatge = array( 'status' => "ERROR", 'message' => 'Dades no vàlides');
    }

    echo json_encode($missatge);
?>