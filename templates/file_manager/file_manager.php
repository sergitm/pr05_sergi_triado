<?php
    session_start();

    $errors = array();

    if (!empty($_POST['modificar'])) {

        // Comprovem que no hagi cap camp buit
        if (empty($_POST['nom'])) {
            $errors['nom']['missing'] = true;        
        }
        if(empty($_POST['newNom'])){
            $errors['newNom']['missing'] = true;
        }
        if (empty($_POST['path'])) {
            $errors['path']['missing'] = true;
        } else {
            if (!is_dir($_POST['path'])) {
                $errors['path']['fake'] = true;
            }
        }

    }

    include "file_manager.view.php";

    if (empty($errors) && !empty($_POST['modificar'])) {
        
    }

?>