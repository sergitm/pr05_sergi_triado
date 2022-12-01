<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    class Usuari implements JsonSerializable {
        
        // PROPERTIES
        private $id;
        private $username;
        private $email;
        private $pwd;
        private $avatar;

        // CONSTRUCTOR
        public function __construct($username, $pwd, $email, $id = null, $avatar = null){
            $this->id = $id;
            $this->username = $username;
            $this->email = $email;
            $this->pwd = $pwd;
            $this->avatar = $avatar;
        }

        // GETTERS
        public function getId(){
            return $this->id;
        }
        public function getUsername(){
            return $this->username;
        }
        public function getEmail(){
            return $this->email;
        }
        public function getPwd(){
            return $this->pwd;
        }
        public function getAvatar(){
            return $this->avatar;
        }

        // SETTERS
        public function setId($id){
            $this->id = $id;
        }
        public function setUsername($username){
            $this->username = $username;
        }
        public function setPwd($pwd){
            $this->pwd = $pwd;
        }
        public function setEmail($email){
            $this->email = $email;
        }
        public function setAvatar($avatar){
            $this->avatar = $avatar;
        }

        // METHODS
        /**
         * create
         *
         * @return boolean
         * 
         * Métode per introduir un usuari a la BBDD
         */
        public function create(){
            $query = "INSERT INTO usuaris (id, username, password, email)
                        VALUES (:id, :username, :pwd, :email)";

            $params = array(':id' => $this->getId(),
                            ':username' => strtoupper($this->getUsername()),
                            ':pwd' => $this->getPwd(),
                            ':email' => strtoupper($this->getEmail())
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
         * Métode per eliminar un usuari de la BBDD
         */
        public function delete(){
            $query = "DELETE FROM usuaris WHERE id = :id";

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
         * Métode per modificar un usuari de la BBDD
         */
        public function update(){
            $query = "UPDATE usuaris SET username = :username, password = :pwd, email = :email, avatar = :avatar WHERE id = :id";

            $params = array(':username' => strtoupper($this->getUsername()), 
                            ':pwd' => $this->getPwd(), 
                            ':email' => strtoupper($this->getEmail()),
                            ':avatar' => $this->getAvatar(), 
                            ':id' => $this->getId());

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
                'username' => $this->getUsername(),
                'pwd' => $this->getPwd(),
                'email' => $this->getEmail(),
                'avatar' => $this->getAvatar(),
                'id' => $this->getId()
            ];
        }
    }
?>