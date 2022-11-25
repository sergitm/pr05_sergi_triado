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

    // $data = json_decode(file_get_contents("php://input"));

    if (!empty($_POST['username']) && !empty($_POST['pwd'])) {
        if (ControlUsuaris::password_update($_POST['username'], $_POST['pwd'])) {

            $missatge = array('message' => "Contrasenya canviada, redirigint en 1 segon..");
        } else {
            $missatge = array( 'error' => "L'usuari ja existeix");
        }
    } else {
        $missatge = array( 'error' => "Les dades no són vàlides");
    }

    echo json_encode($missatge);
?>