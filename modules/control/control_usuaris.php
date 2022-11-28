<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/

    class ControlUsuaris {
        private static $llista_usuaris;

        public static function getUsuaris(){
            return self::$llista_usuaris;
        }

        public static function user_exists($username){
            $query = "SELECT * FROM usuaris WHERE username = :username";

            $params = array(
                'username' => strtoupper($username)
            );

            Connexio::connect();

            $stmt = Connexio::execute($query, $params);

            if($stmt->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }

        public static function email_exists($email){
            $query = "SELECT * FROM usuaris WHERE email = :email";

            $params = array(
                'email' => strtoupper($email)
            );

            Connexio::connect();

            $stmt = Connexio::execute($query, $params);

            if($stmt->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }

        public static function user_auth($id, $pwd){
            $query = "SELECT * FROM usuaris WHERE (username = :id OR email = :id) AND password = :pwd";

            $params = array(
                'id' => strtoupper($id),
                'pwd' => $pwd
            );

            Connexio::connect();

            $stmt = Connexio::execute($query, $params);

            if($stmt->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }

        public static function get_usuari($identifier){
            $query = "SELECT * FROM usuaris WHERE (username = :id OR email = :id)";
            $params = array(
                ':id' => strtoupper($identifier)
            );

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);

            $result = $stmt->fetchAll();

            $num = count($result);

            if ($num > 0) {
                $row = $result[0];

                $usuari = new Usuari($row['username'], $row['password'], $row['email'], $row['id']);

                Connexio::close();

                return $usuari;
            } else {
                Connexio::close();
                throw new Exception("No s'han trobat usuaris.");
            }
        }

        public static function password_update($username, $pwd){
            $usuari = self::get_usuari($username);

            if($usuari === null){
                return false;
            }

            $usuari->setPwd($pwd);

            return $usuari->update();
        }
    }

?>