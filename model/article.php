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
        private $image;

        // CONSTRUCT
        public function __construct($article, $autor, $id = null, $image = null){
            $this->article = $article;
            $this->autor = $autor;
            $this->id = $id;
            $this->image = $image;
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
        public function getImage(){
            return $this->image;
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
        public function setImage($image){
            $this->image = $image;
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
            $query = "INSERT INTO articles (id, article, user, imatge)
                        VALUES (:id, :article, :autor, :imatge)";

            $params = array(':id' => $this->getId(),
                            ':article' => $this->getArticle(),
                            ':autor' => strtoupper($this->getAutor()),
                            ':imatge' => $this->getImage()
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
            $query = "UPDATE articles SET user = :autor, article = :article, imatge = :imatge WHERE id = :id";

            $params = array(':autor' => $this->getAutor(), ':article' => $this->getArticle(),':imatge' => $this->getImage(), ':id' => $this->getId());

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
                'imatge' => $this->getImage(),
                'autor' => $this->getAutor()
            ];
        }
}
?>