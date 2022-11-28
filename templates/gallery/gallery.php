<?php
    session_start();

    include "../../model/http.request.php";
    $http = new HttpRequest("../../environment/environment.json");
    $environment = $http->getEnvironment();

    // Gestió de la pujada d'imatges
    $errors = array();
    $uploadOk = 0;

    if (isset($_POST['enviar'])) {
        
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

        } else {
            $errors['img']['missing'] = true;
        }

        if ($uploadOk != 0 && empty($errors)) {
            try {                
                $data = array(
                    'username' => strtoupper($_SESSION['username']),
                    'path' => "public/assets/img/" . basename($_FILES['upload_img']['name'])
                );
                
                $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->imatge->create;
                
                $res = $http->makePostRequest($url, $data);
                if ($res) {
                    if (isset($res->status) && $res->status === 'OK') {
                        move_uploaded_file($_FILES["upload_img"]["tmp_name"], $target_file);
                        $success = true;
                        unset($_POST);
                        unset($_FILES);
                    } else {
                        throw new Exception($res->message);
                    }
                } else {
                    throw new Exception('Hi ha hagut un error a la base de dades');
                }
            } catch (\Throwable $e) {
                echo $e;
                $failure = true;
            }
        }
    }

    // Gestió de lectura d'imatges
    // Establim el numero de pagina en la que l'usuari es troba.
    # si no troba cap valor, assignem la pagina 1.
    $pagina = (empty($_GET['pagina'])) ? 1 : intval($_GET['pagina']);

    // definim quantes imatges per pagina volem carregar.

    $img_x_pag = (!empty($_GET['img_x_pag']) && (intval($_GET['img_x_pag']) > 0)) ? intval($_GET['img_x_pag']) : 12;

    // Revisem des de quina imatge anem a carregar, depenent de la pagina on es trobi l'usuari.
    # Comprovem si la pagina en la que es troba es més gran d'1, sino carreguem des de l'article 0.
    # Si la pagina es més gran que 1, farem un càlcul per saber des de quina imatge carreguem

    $primera_imatge = ($pagina > 1) ? ($pagina - 1) * $img_x_pag : 0;

    // Fem la petició HTTP al backend per rebre els imatges

    $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->imatge->read;

    $data = array('offset' => $primera_imatge, 'row_count' => $img_x_pag);

    # Si l'usuari està loguejat, incluïm el seu nom d'usuari a la petició per rebre les SEVES imatges

    if (isset($_SESSION['username'])) {
        $data['username'] = strtoupper($_SESSION['username']);
    }

    # Fem la petició i rebem les dades
    $result = $http->makePostRequest($url, $data);

    if ($result != null) {
        $num = count($result->imatges);
    } else {
        $num = 0;
    }

    // Calculem el total d'imatges per a poder conèixer el número de pàgines de la paginació
    $quantitat = $result->count ?? 0 ;

    // Calculem el numero de pagines que tindrà la paginació. Llavors hem de dividir el total d'imatges entre les imatges per pagina
    $maxim_pagines = ($quantitat % $img_x_pag > 0) ? floor($quantitat / $img_x_pag + 1) : floor($quantitat / $img_x_pag);

    // Incluim la vista
    include "gallery.view.php";

?>