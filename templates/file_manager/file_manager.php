<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
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

    // Submit 
    if (empty($errors) && !empty($_POST['modificar'])) {
        $all_files = scandir($_POST['path']);
        if(substr($_POST['path'], -1) === '/' || substr($_POST['path'], -1) === '\\'){
            $path = $_POST['path'];
        } else {
            $path = $_POST['path'] . '/';
        }
        $i = 0;
        foreach ($all_files as $file) {
            if (preg_match('/(' . $_POST['nom'] . ')/', $file)) {
                $nouNom = preg_replace('/(' . $_POST['nom'] . ')/', $_POST['newNom'], $file);
                rename($path . $file, $path . $nouNom);
                $i++;
            }
        }
        if ($i > 0) {
            print "<p class='text-success d-flex justify-content-center my-2 fw-bold'>S'han modificat " . $i . " fitxers.</p>";
        } else {
            print "<p class='text-danger d-flex justify-content-center my-2 fw-bold'>No s'ha trobat cap fitxer per canviar.</p>";
        }
    }

    (isset($_SESSION['username'])) ? '' : header("Location: " . $environment->protocol . $environment->baseUrl);

?>