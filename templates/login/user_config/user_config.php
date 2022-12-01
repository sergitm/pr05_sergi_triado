<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
session_start();
include "../../../model/http.request.php";

// Aconseguim les dades de l'usuari que vol modificar

$http = new HttpRequest("../../../environment/environment.json");
$environment = $http->getEnvironment();
$url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->usuari->read;
$data = array('check' => true, 'identifier' => $_SESSION['username'], 'imatges' => true);

$result = $http->makePostRequest($url, $data);

if ($result != null && isset($result->user)) {

    $usuari = $result->user;
    $images = $result->imatges;

    $errors = array();

    if (!empty($_POST['modificar'])) {
        
        // Validem les dades del formulari
        include "../../../model/validator.php";
        if (!empty($_POST['newUsername'])) {
            if (Validator::usernameExists($_POST['newUsername'], "../../../") && $_POST['newUsername'] != strtolower($usuari->username)){
                $errors['username']['exists'] = true;
            }  
        }
        
        if (!empty($_POST['newMail'])) {
            if (Validator::emailExists($_POST['newMail'], "../../../") && $_POST['newMail'] != strtolower($usuari->email)){
                $errors['email']['exists'] = true;
            }
            
            $emailPattern = '/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/';
            if (!preg_match($emailPattern, $_POST['newMail'])) {
                $errors['email']['invalid'] = true;
            }
        }
        
        // Comprovem que s'ha seleccionat un fitxer
        if (!empty($_FILES['upload_img']['name'])) {
            // Directori on s'enviarà l'imatge i extensió per comprovar
            $target_dir = "../../../public/assets/img/";
            $target_file = $target_dir . basename($_FILES['upload_img']['name']);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            // Comprovem que és una imatge
            if(!empty($_FILES['upload_img']['tmp_name'])){
                $check = getimagesize($_FILES['upload_img']['tmp_name']);
                
                if ($check !== false) {
                } else {
                    $errors['img']['fake'] = true;
                }    
            } else {
                $uploadOk = 0;
                $errors['img']['sizeLimit'] = true;
            }
            
            // Comprovem que el fitxer no existeixi ja
            if (file_exists($target_file)) {
                $errors['img']['repeated'] = true;
            }
            
            // Comprovem que la imatge és del format que ens interessa
            if ($imageFileType != 'jpg' && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $errors['img']['formatNotAllowed'] = true;
            } 
        } 
        
        // Comprovem les dades del formulari, si un camp del formulari està buit ho interpretarem com que no ha de canviar a BBDD
        $newName = (empty($_POST['newUsername'])) ? $usuari->username : $_POST['newUsername'];
        $newMail = (empty($_POST['newMail'])) ? $usuari->email : $_POST['newMail'];
    }

    if (empty($errors) && !empty($_POST['modificar'])) {
        try {                
            $data = array(
                'id' => $usuari->id,
                'username' => strtoupper($newName),
                'email' => strtoupper($newMail)
            );

            if (!empty($_POST['imatge'])) {
                $data['avatar'] = $_POST['imatge'];
            }
            if (!empty($_FILES['upload_img']['name'])) {
                unset($data['avatar']);
                $data['newAvatar'] = "public/assets/img/" . basename($_FILES['upload_img']['name']);
                $upload = true;
            }
            
            $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->usuari->update;
            
            $res = $http->makePostRequest($url, $data);

            if ($res) {
                if (isset($res->status) && $res->status === 'OK') {
                    if (isset($upload)) {
                        move_uploaded_file($_FILES["upload_img"]["tmp_name"], $target_file);
                    }
                    $success = true;
                    unset($_POST);
                    unset($_FILES);
                } else {
                    throw new Exception('Hi ha hagut un error a la base de dades');
                }
            } else {
                throw new Exception('Hi ha hagut un error a la base de dades');
            }
        } catch (\Throwable $e) {
            echo $e;
            $failure = true;
        }
    }
    // Tornem a llegir el nou usuari per mostrar les seves dades actualitzades abans d'ensenyar la vista
    if (isset($success) && $success == true) {
        $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->usuari->read;
        $data = array('check' => true, 'identifier' => $_SESSION['username'], 'imatges' => true);

        $result = $http->makePostRequest($url, $data);

        $usuari = $result->user;
        $images = $result->imatges;
    }

    // Incluim la vista
    include "user_config.view.php";

    if (!empty($_POST['eliminar'])) {
        include "delete.view.php";
    }

} else {

    header("refresh:1;url=" . $environment->protocol . $environment->baseUrl);
    print "<h1 class='text-danger' style='text-align:center'>No existeix l'usuari</h1>";

}


?>