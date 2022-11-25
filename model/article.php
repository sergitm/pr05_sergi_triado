<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    class Article implements JsonSerializable{

        // PROPERTIES
        private $id;
        private $article;
        private $autor;

        // CONSTRUCT
        public function __construct($article, $autor, $id = null){
            $this->article = $article;
            $this->autor = $autor;
            $this->id = $id;
        }

        // GETTERS
        public function getArticle(){
            return $this->article;
        }
        public function getAutor(){
            return $this->autor;
        }
        public function getId(){
            return $this->id;
        }

        // SETTERS
        public function setArticle($article){
            $this->article = $article;
        }
        public function setAutor($autor){
            $this->autor = $autor;
        }
        public function setId($id){
            $this->id = $id;
        }

        // METHODS        
        /**
         * create
         *
         * @return boolean
         * 
         * Métode per introduir un article a la BBDD
         */
        public function create(){
            $query = "INSERT INTO articles (id, article, user)
                        VALUES (:id, :article, :autor)";

            $params = array(':id' => $this->getId(),
                            ':article' => $this->getArticle(),
                            ':autor' => strtoupper($this->getAutor()), 
            );

            Connexio::connect();
            $stmt = Connexio::execute($query,$params);

            if ($stmt) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        
        /**
         * delete
         *
         * @return void
         * 
         * Métode per eliminar un article de la BBDD
         */
        public function delete(){
            $query = "DELETE FROM articles WHERE id = :id";

            $params = array(':id' => $this->getId());

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);
            Connexio::close();
            
            if ($stmt) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        
        /**
         * update
         *
         * @return void
         * 
         * Métode per modificar un article de la BBDD
         */
        public function update(){
            $query = "UPDATE articles SET user = :autor, article = :article WHERE id = :id";

            $params = array(':autor' => $this->getAutor(), ':article' => $this->getArticle(), ':id' => $this->getId());

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);
            Connexio::close();
            
            if ($stmt) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        
        /**
         * jsonSerialize
         *
         * @return JSONObject
         * 
         * Métode de la interfícia JsonSerializable que indica la seva estructura quan es converteixi a JSON
         */
        public function jsonSerialize(){
            return [
                'article' => $this->getArticle(),
                'id' => $this->getId(),
                'autor' => $this->getAutor()
            ];
        }
}
?>