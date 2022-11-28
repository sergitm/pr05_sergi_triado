<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    class Imatge implements JsonSerializable {
        
        // PROPERTIES
        private $id;
        private $path;
        private $user;

        // CONSTRUCTOR
        public function __construct($path, $user, $id = null){
            $this->id = $id;
            $this->path = $path;
            $this->user = $user;
        }

        // GETTERS
        public function getId(){
            return $this->id;
        }
        public function getPath(){
            return $this->path;
        }
        public function getUser(){
            return $this->user;
        }

        // SETTERS
        public function setId($id){
            $this->id = $id;
        }
        public function setPath($path){
            $this->path = $path;
        }
        public function setUser($user){
            $this->user = $user;
        }

        // METHODS
        /**
         * create
         *
         * @return boolean
         * 
         * Métode per introduir una imatge a la BBDD
         */
        public function create(){
            $query = "INSERT INTO imatges (id, path, user)
                        VALUES (:id, :path, :user)";

            $params = array(':id' => $this->getId(),
                            ':path' => $this->getPath(),
                            ':user' => $this->getUser()
            );

            Connexio::connect();
            $stmt = Connexio::execute($query,$params);
            Connexio::close();
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
         * Métode per eliminar una imatge de la BBDD
         */
        public function delete(){
            $query = "DELETE FROM imatges WHERE id = :id";

            $params = array(':id' => $this->getId());

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);
            Connexio::close();

            return $stmt;
        }
        
        /**
         * update
         *
         * @return void
         * 
         * Métode per modificar una imatge de la BBDD
         */
        public function update(){
            $query = "UPDATE imatges SET path = :path, user = :user WHERE id = :id";

            $params = array(':path' => $this->getPath(), ':user' => $this->getUser(), ':id' => $this->getId());

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
         * Métode de la interfície JsonSerializable que indica la seva estructura quan es converteixi a JSON
         */
        public function jsonSerialize(){
            return [
                'path' => $this->getPath(),
                'user' => $this->getUser(),
                'id' => $this->getId()
            ];
        }
    }
?>