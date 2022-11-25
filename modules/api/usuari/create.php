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

    if (!empty($_POST['username']) && !empty($_POST['pwd']) && !empty($_POST['email'])) {
        if (!ControlUsuaris::user_exists($_POST['username'],$_POST['email'])) {
            $user = new Usuari($_POST['username'], $_POST['pwd'], $_POST['email']);

            $res = $user->create();

            $missatge = ($res) ? array('message' => "Usuari creat", 'username' => $_POST['username']) : array('error' => "Alguna cosa ha fallat");
        } else {
            $missatge = array( 'error' => "L'usuari ja existeix");
        }
    } else {
        $missatge = array( 'error' => "Les dades no són vàlides");
    }

    echo json_encode($missatge);
?>