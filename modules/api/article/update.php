<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
require_once "../../config/database.php";
require_once "../../control/llista_articles.php";
require_once "../../control/control_usuaris.php";
require_once "../../control/image_manager.php";
require_once "../../../model/imatge.php";
require_once "../../../model/article.php";
require_once "../../../model/user.php";

// $data = json_decode(file_get_contents("php://input"));

if (!empty($_POST['id']) && !empty($_POST['article'])) {
    if (!empty($_POST['imatge'])) {
        $result = LlistaArticles::update_article($_POST['id'], $_POST['article'], $_POST['imatge']);
    } elseif(!empty($_POST['newImatge'])) {
        $result = LlistaArticles::update_article_new_image($_POST['id'], $_POST['article'], $_POST['newImatge']);
    } else {
        $result = LlistaArticles::update_article($_POST['id'], $_POST['article']);
    }

    if ($result) {
        $missatge = array('success' => true);
    } else {
        $missatge = array('error' => true);
    }
}

echo json_encode($missatge);
?>