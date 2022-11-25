<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
ini_set('session.gc_maxlifetime', 1800);
session_set_cookie_params(1800);
session_start();

$env = json_decode(file_get_contents("../../../environment/environment.json"));
$environment = $env->environment;


$errors = array();
if (!empty($_POST['check'])) {
    if (empty($_POST['identifier'])) $errors['identifier']['missing'] = true;
}

if (!empty($_POST['check']) && !empty($_POST['identifier'])) {
    include "../../../model/Validator.php";
    $res = Validator::userExist($_POST['identifier']);

    if ($res != null) {
        if($res->check){
            $userExists = true;
            $email = strtolower($res->user->email);
            $username = ucwords(strtolower($res->user->username));
            
            session_regenerate_id(true);
            $_SESSION = array();
            $_SESSION['tempUsername'] = $res->user->username;
            require "mail_sender.php";
        } else {
            $userExists = false;
        }
    } else {
        $userExists = false;
    }
}

if (!isset($_SESSION['username'])) {
    include "user_check.view.php";
} else {
    header("Location: " . $environment->protocol . $environment->baseUrl);
}

?>