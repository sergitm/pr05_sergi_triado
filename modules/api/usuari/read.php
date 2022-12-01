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

    if (!empty($_POST['check'])) {
        if (!empty($_POST['username'])) {
            if (ControlUsuaris::user_exists($_POST['username'])) $res = array('username' => true);
        }
        if (!empty($_POST['email'])) {
            if (ControlUsuaris::email_exists($_POST['email'])) $res = array('email' => true);
        }
        if (!empty($_POST['identifier'])) {
            try{
                $user = ControlUsuaris::get_usuari($_POST['identifier']);
    
                $res = array(
                    'check' => true,
                    'user' => $user
                );
            } catch(Exception $e){
                $res = array(
                    'check' => false,
                    'missatge' => "L'usuari no existeix"
                );
            }
        }
        if (!empty($_POST['imatges'])) {
            ImageManager::read_all_images($_POST['identifier']);

            $llista_imatges = ImageManager::getImatges();

            $res['imatges'] = $llista_imatges;
        }
    }

    if (!empty($_POST['identifier']) && !empty($_POST['login'])) {
        try{
            $user = ControlUsuaris::get_usuari($_POST['identifier']);

            $res = array(
                'auth' => true,
                'username' => $user->getUsername(),
                'phash' => $user->getPwd()
            );
        } catch(Exception $e){
            $res = array(
                'auth' => false,
                'missatge' => "L'usuari no existeix"
            );
        }
    }

    echo json_encode($res);
?>