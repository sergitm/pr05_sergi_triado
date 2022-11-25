<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    ini_set('session.gc_maxlifetime', 1800);
    session_set_cookie_params(1800);
    session_start();
    $_SESSION['tries'] ??= 1;
    if (isset($_SESSION['username'])) {

        $env = json_decode(file_get_contents("../../environment/environment.json"));
        $environment = $env->environment;
        $url = $environment->protocol . $environment->baseUrl . $environment->dir->templates->logout;

        header('Location: ' . $url);
        
    } else {
        if (!empty($_POST['login'])) {
            
            $errors = array();

            (empty($_POST['identifier'])) ? $errors['identifier']['missing'] = true : "";

            (empty($_POST['pwd'])) ? $errors['pwd']['missing'] = true : "";
        }

        include "login.view.php";
        include "../../model/validator.php";
        
        if(isset($_POST['g-recaptcha-response'])) {

            $captcha = $_POST['g-recaptcha-response'];
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LehXggjAAAAABT6PC82AnmT2htXRHsVxerjwHyc&response=".$captcha);
            $g_response = json_decode($response);

            if ($g_response->success === true) {
                if(Validator::auth($_POST['identifier'], $_POST['pwd'])){
                    $_SESSION['tries'] = 1;  
                    header("Location: " . $environment->protocol . $environment->baseUrl);
                } 
            }
        }
        if(!empty($_POST['login']) && empty($errors)){
            if(Validator::auth($_POST['identifier'], $_POST['pwd'])){
                $_SESSION['tries'] = 1;     
                header("Location: " . $environment->protocol . $environment->baseUrl);
            } else {
                $_SESSION['tries']++;
            }
        }
    }
