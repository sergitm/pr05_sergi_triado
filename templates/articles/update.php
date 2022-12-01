<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    session_start();
    include "../../model/http.request.php";

    $http = new HttpRequest("../../environment/environment.json");
    $environment = $http->getEnvironment();
    $uploadOk = 0;

    if (!empty($_POST)) {
        $keys = array_keys($_POST);
        foreach ($keys as $value) {
            if (is_int($value)) {

                $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->article->read;
                $data = array('id' => $value, 'username' => $_SESSION['username']);

                $result = $http->makePostRequest($url, $data);
                if ($result != null && isset($result->article)) {
                    $article = $result->article;
                    $images = $result->images;
                    include "update.view.php";
                } else {
                    header("refresh:1;url=" . $environment->protocol . $environment->baseUrl);
                    print "<h1 class='text-danger' style='text-align:center'>No existeix el post</h1>";
                }
            }
        }
    } else {
        header("Location: " . $environment->protocol . $environment->baseUrl);
    }

    
    if (isset($_POST['newArticle']) && isset($_POST['updateArticle']) && !empty($_POST['newArticle']) ) {

        // Comprovem que s'ha seleccionat un fitxer
        if (!empty($_FILES['upload_img']['name'])) {
            // Directori on s'enviarà l'imatge i extensió per comprovar
            $target_dir = "../../public/assets/img/";
            $target_file = $target_dir . basename($_FILES['upload_img']['name']);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Comprovem que és una imatge
            if(!empty($_FILES['upload_img']['tmp_name'])){
                $check = getimagesize($_FILES['upload_img']['tmp_name']);
                
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                    $errors['img']['fake'] = true;
                }    
            } else {
                $uploadOk = 0;
                $errors['img']['sizeLimit'] = true;
            }

            // Comprovem que el fitxer no existeixi ja
            if (file_exists($target_file)) {
                $errors['img']['repeated'] = true;
                $uploadOk = 0;
            }

            // Comprovem que la imatge és del format que ens interessa
            if ($imageFileType != 'jpg' && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $uploadOk = 0;
                $errors['img']['formatNotAllowed'] = true;
            } else {
                $uploadOk = 1;
            }
        }

        // Petició per fer update
        
        $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->article->update;
        $data = array('id' => $_POST['id'], 'article' => $_POST['newArticle']);

        if (isset($_POST['imatge']) && !empty($_POST['imatge'])) {
            $data['imatge'] = $_POST['imatge'];
        }

        if ($uploadOk != 0) {
            unset($data['imatge']);
            $data['newImatge'] = "public/assets/img/" . basename($_FILES['upload_img']['name']);
        }
        $result = $http->makePostRequest($url, $data);
        
        if ($result != null && isset($result->success)) {
            move_uploaded_file($_FILES["upload_img"]["tmp_name"], $target_file);
            header("Location: " . $environment->protocol . $environment->baseUrl);
        } else {
            header("refresh:1;url=" . $environment->protocol . $environment->baseUrl);
            print "<h1 class='text-danger' style='text-align:center'>Hi ha hagut un error al actualitzar l'article</h1>";
        }
    }
    
?>