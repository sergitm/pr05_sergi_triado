<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    class LlistaArticles {

        private static $llista_articles;

        //GETTER
        public static function getArticles(){
            return self::$llista_articles;
        }

        public static function read_articles($offset, $row_count){
            self::$llista_articles = array();

            $query = "SELECT a.id, a.article, u.username, i.path FROM articles a LEFT JOIN usuaris u ON a.user = u.id LEFT JOIN imatges i ON a.imatge = i.id LIMIT :offset, :row_count";
            $params = array(':offset' => $offset, ':row_count' => $row_count);

            Connexio::connect();
            $stmt = Connexio::execute_int_params($query, $params);

            $result = $stmt->fetchAll();

            $num = count($result);

            if ($num > 0) {
                foreach ($result as $row) {
                    extract($row);
                    
                    $article = new Article($row['article'], $row['username'], $row['id'],  $row['path']);

                    array_push(self::$llista_articles, $article);
                }
            }
            Connexio::close();
        }

        public static function read_articles_by_user($offset, $row_count, $username){
            self::$llista_articles = array();

            $query = "SELECT a.id, a.article, u.username, i.path FROM articles a LEFT JOIN usuaris u ON a.user = u.id LEFT JOIN imatges i ON a.imatge = i.id WHERE u.username = :username LIMIT :offset, :row_count";

            Connexio::connect();
            $conn = Connexio::getConn();
            $stmt = $conn->prepare($query);

            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':row_count', $row_count, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetchAll();

            $num = count($result);

            if ($num > 0) {
                foreach ($result as $row) {
                    extract($row);
                    
                    $article = new Article($row['article'], $row['username'], $row['id'], $row['path']);

                    array_push(self::$llista_articles, $article);
                }
            }
            Connexio::close();
        }

        public static function articles_count(){
            $query = "SELECT COUNT(id) AS quantitat FROM articles";

            Connexio::connect();
            $stmt = Connexio::execute($query);

            $count = $stmt->fetch();
            return intval($count['quantitat']);
        }

        public static function articles_count_by_user($username){
            $query = "SELECT COUNT(a.id) AS quantitat FROM articles a LEFT JOIN usuaris u ON a.user = u.id WHERE u.username = :username";

            $params = array(':username' => $username);

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);

            $count = $stmt->fetch();
            return intval($count['quantitat']);
        }

        public static function article_find($id){
            $query = "SELECT * FROM articles WHERE id = :id";
            $params = array(':id' => $id);

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);

            $result = $stmt->fetchAll();
            Connexio::close();

            $num = count($result);

            if ($num > 0) {
                foreach ($result as $row) {
                    extract($row);
                    
                    $article = new Article($row['article'], $row['user'], $row['id']);

                    return $article;
                }
            } else {
                return null;
            }
        }

        public static function new_article($article, $autor, $imatge = null){
            $usuari = ControlUsuaris::get_usuari($autor);

            $article = new Article($article, $usuari->getId());

            if ($imatge != null) {
                $newImage = new Imatge($imatge,$usuari->getId());
                $newImage->create();

                $image_find = ImageManager::find_image_by_path($imatge);
                $article->setImage($image_find->getId());
            }

            return $article->create();
        }

        public static function delete_article($id){
            $article = self::article_find($id);

            if($article === null){
                return false;
            }
            return $article->delete();
        }

        public static function update_article($id, $newArticle, $image = null){
            $article = self::article_find($id);

            if ($article === null) {
                return false;
            }

            if ($image !== null) {
                $article->setImage($image);
            }
            
            $article->setArticle($newArticle);
            return $article->update();
        }
    }
?>