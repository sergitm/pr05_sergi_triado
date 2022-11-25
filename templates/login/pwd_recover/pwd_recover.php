<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    session_start();

    include "../../../model/http.request.php";

    $http = new HttpRequest("../../../environment/environment.json");
    $environment = $http->getEnvironment();
    
    if((!empty($_GET['validation']) && session_id() === $_GET['validation']) || (!empty($_POST['validation']) && session_id() === $_POST['validation'])){

        $errors = array();

        if(!empty($_POST['change'])){
    
            (empty($_POST['pwdR'])) ? $errors['pwdR']['missing'] = true : "";
    
            if(empty($_POST['pwd'])){
                $errors['pwd']['missing'] = true;
            } else {
                $pattern = '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/';
    
                (!preg_match($pattern, $_POST['pwd'])) ? $errors['pwd']['invalid'] = true : "";
                (!empty($_POST['pwdR']) && ($_POST['pwd'] !== $_POST['pwdR'])) ? $errors['pwd']['unmatched'] = true : "";
            }
        }

        include "pwd_recover.view.php";

        if(!empty($_POST['change']) && empty($errors)){
    
            $data = array(
                'username' => $_SESSION['tempUsername'],
                'pwd' => password_hash($_POST['pwd'], PASSWORD_BCRYPT));
    
            $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->usuari->update;
            
            $res = $http->makePostRequest($url, $data);
                 
            if ($res) {
                if (isset($res->error)) {
                    print "<h1 class='text-danger' style='text-align:center'>" . $res->error . "</h1>";
                } else {
                    print "<h1 class='text-success' style='text-align:center'>" . $res->message . "</h1>";

                    header("refresh:1;url=" . $environment->protocol . $environment->baseUrl . $environment->dir->templates->login);
                }
            } else {
                print "<h1 class='text-danger' style='text-align:center'>Hi ha hagut un error en el procés</h1>";
            }
        }
    } else {
        header("Location: " . $environment->protocol . $environment->baseUrl);
    }

?>