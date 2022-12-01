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
            $query = "SELECT u.id, u.username, u.password, u.email, i.path FROM usuaris u LEFT JOIN imatges i ON u.avatar = i.id WHERE (u.username = :id OR u.email = :id)";
            $params = array(
                ':id' => strtoupper($identifier)
            );

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);

            $result = $stmt->fetchAll();

            $num = count($result);

            if ($num > 0) {
                $row = $result[0];

                $usuari = new Usuari($row['username'], $row['password'], $row['email'], $row['id'], $row['path']);

                Connexio::close();

                return $usuari;
            } else {
                Connexio::close();
                throw new Exception("No s'han trobat usuaris.");
            }
        }

        public static function get_usuari_by_id($id){
            $query = "SELECT * FROM usuaris WHERE id = :id";
            $params = array(
                ':id' => strtoupper($id)
            );

            Connexio::connect();
            $stmt = Connexio::execute($query, $params);

            $result = $stmt->fetchAll();

            $num = count($result);

            if ($num > 0) {
                $row = $result[0];

                $usuari = new Usuari($row['username'], $row['password'], $row['email'], $row['id'], $row['avatar']);

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

        public static function update_user_create_avatar($id, $username, $email, $avatar = null){
            $usuari = self::get_usuari_by_id($id);

            if ($usuari === null) {
                return false;
            }

            if ($username != $usuari->getUsername()) {
                $usuari->setUsername($username);
            }
            if ($email != $usuari->getEmail()) {
                $usuari->setEmail($email);
            }
            if($avatar != null){
                $newImage = new Imatge($avatar, $usuari->getId());
                $newImage->create();
                $image_find = ImageManager::find_image_by_path($avatar);
                $usuari->setAvatar($image_find->getId());
            }

            return $usuari->update();
        }

        public static function update_user($id, $username, $email, $avatar = null){
            $usuari = self::get_usuari_by_id($id);

            if ($usuari === null) {
                return false;
            }

            if ($username != $usuari->getUsername()) {
                $usuari->setUsername($username);
            }
            if ($email != $usuari->getEmail()) {
                $usuari->setEmail($email);
            }
            
            $usuari->setAvatar($avatar);

            return $usuari->update();
        }

        public static function delete_user($id){
            $usuari = self::get_usuari_by_id($id);

            if($usuari === null){
                return false;
            }
            return $usuari->delete();
        }
    }

?>