<?php

/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/

    ini_set('session.gc_maxlifetime', 1800);
    session_set_cookie_params(1800);
    session_start();
    $errors = array();
    include "../../model/validator.php";

    // var_dump($_POST);
    if(!empty($_POST['registrar'])){
        if(empty($_POST['username'])){
            $errors['username']['missing'] = true;
        } else {
            $userValidator = Validator::usernameExists($_POST['username']);
            ($userValidator) ? $errors['username']['exists'] = true : "";
        }

        (empty($_POST['pwdRepeat'])) ? $errors['pwdR']['missing'] = true : "";

        if (empty($_POST['email'])) {
            $errors['email']['missing'] = true;
        } else {
            $emailPattern = '/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/';
            (!preg_match($emailPattern, $_POST['email'])) ? $errors['email']['invalid'] = true : "";
            $emailValidator = Validator::emailExists($_POST['email']);
            ($emailValidator) ? $errors['email']['exists'] = true : "";
        }

        if(empty($_POST['pwd'])){
            $errors['pwd']['missing'] = true;
        } else {
            $pattern = '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/';

            (!preg_match($pattern, $_POST['pwd'])) ? $errors['pwd']['invalid'] = true : "";
            (!empty($_POST['pwdRepeat']) && ($_POST['pwd'] !== $_POST['pwdRepeat'])) ? $errors['pwd']['unmatched'] = true : "";
            
        }
    }

    include "signup.view.php";
    
    if(!empty($_POST['registrar']) && empty($errors)){
        $http = new HttpRequest("../../environment/environment.json");
        $environment = $http->getEnvironment();

        $data = array(
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'pwd' => password_hash($_POST['pwd'], PASSWORD_BCRYPT));

        $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->usuari->create;
        
        $res = $http->makePostRequest($url, $data);
             
        if ($res) {
            if (isset($res->error)) {
                print "<h1 class='text-danger' style='text-align:center'>" . $res->error . "</h1>";
            } else {
                session_regenerate_id(true);
                $_SESSION['username'] = ucwords(strtolower($res->username));
                header("refresh:1;url=" . $environment->protocol . $environment->baseUrl);
                
                print "<h1 class='text-success' style='text-align:center'>" . $res->message . "</h1>";
            }
        } else {
            print "<h1 class='text-danger' style='text-align:center'>Hi ha hagut un error amb el registre</h1>";
        }
    }
?>

