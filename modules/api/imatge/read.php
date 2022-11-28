<?php 
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    require_once "../../config/database.php";
    require_once "../../control/image_manager.php";
    require_once "../../../model/imatge.php";
    
    // $data = json_decode(file_get_contents("php://input"));
    
    if (isset($_POST['offset']) && isset($_POST['row_count'])) {
        if(empty($_POST['username'])){
            ImageManager::read_images($_POST['offset'], $_POST['row_count']);

            $llista_imatges = ImageManager::getImatges();
            $count = ImageManager::image_count();

            $result = array(
                'imatges' => $llista_imatges,
                'count' => $count
            );
        } else {
            ImageManager::read_images_by_user($_POST['offset'], $_POST['row_count'], $_POST['username']);

            $llista_imatges = ImageManager::getImatges();
            $count = ImageManager::image_count_by_user($_POST['username']);

            $result = array(
                'imatges' => $llista_imatges,
                'count' => $count
            );
        }
    }
    if (isset($_POST['id'])) {
        $imatge = ImageManager::find_image($_POST['id']);

        $result = array('imatge' => $imatge);
    }

    echo json_encode($result);
?>