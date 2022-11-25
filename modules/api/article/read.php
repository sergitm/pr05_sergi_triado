<?php 
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    require_once "../../config/database.php";
    require_once "../../control/llista_articles.php";
    require_once "../../../model/article.php";
    
    // $data = json_decode(file_get_contents("php://input"));
    
    if (isset($_POST['offset']) && isset($_POST['row_count'])) {
        if(empty($_POST['username'])){
            LlistaArticles::read_articles($_POST['offset'], $_POST['row_count']);

            $llista_articles = LlistaArticles::getArticles();
            $count = LlistaArticles::articles_count();

            $result = array(
                'articles' => $llista_articles,
                'count' => $count
            );
        } else {
            LlistaArticles::read_articles_by_user($_POST['offset'], $_POST['row_count'], $_POST['username']);

            $llista_articles = LlistaArticles::getArticles();
            $count = LlistaArticles::articles_count_by_user($_POST['username']);

            $result = array(
                'articles' => $llista_articles,
                'count' => $count
            );
        }
    }
    if (isset($_POST['id'])) {
        $article = LlistaArticles::article_find($_POST['id']);

        $result = array('article' => $article);
    }

    echo json_encode($result);
?>