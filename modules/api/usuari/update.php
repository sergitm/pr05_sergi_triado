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
    require_once "../../control/control_usuaris.php";
    require_once "../../../model/imatge.php";
    require_once "../../control/image_manager.php";

    // $data = json_decode(file_get_contents("php://input"));

    if (!empty($_POST['username']) && !empty($_POST['pwd'])) {
        if (ControlUsuaris::password_update($_POST['username'], $_POST['pwd'])) {

            $missatge = array('message' => "Contrasenya canviada, redirigint en 1 segon..");
        } else {
            $missatge = array( 'error' => "L'usuari ja existeix");
        }
    } elseif(!empty($_POST['username']) && !empty($_POST['email'])){
        if (!empty($_POST['avatar'])) {
            $result = ControlUsuaris::update_user($_POST['id'], $_POST['username'], $_POST['email'], $_POST['avatar']);
        } elseif (!empty($_POST['newAvatar'])) {
            $result = ControlUsuaris::update_user_create_avatar($_POST['id'], $_POST['username'], $_POST['email'], $_POST['newAvatar']);
        } else {
            $result = ControlUsuaris::update_user($_POST['id'], $_POST['username'], $_POST['email']);
        }

        if ($result) {
            $missatge = array('status' => 'OK');
        } else {
            $missatge = array('status' => 'ERROR');
        }
    } else {
        $missatge = array( 'error' => "Les dades no són vàlides");
    }

    echo json_encode($missatge);
?>