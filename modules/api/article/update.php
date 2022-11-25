<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
require_once "../../config/database.php";
require_once "../../control/llista_articles.php";
require_once "../../control/control_usuaris.php";
require_once "../../../model/article.php";
require_once "../../../model/user.php";

// $data = json_decode(file_get_contents("php://input"));

if (!empty($_POST['id']) && !empty($_POST['article'])) {
    $result = LlistaArticles::update_article($_POST['id'], $_POST['article']);

    if ($result) {
        $missatge = array('success' => true);
    } else {
        $missatge = array('error' => true);
    }
}

echo json_encode($missatge);
?>