<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    require_once "http.request.php";

    class Validator{
        /**
         * Username Exists
         *
         * @return boolean
         * 
         * Métode que envia una petició al backend per comprovar a la BBDD si el nom d'usuari ja existeix
         */
        public static function usernameExists($username, $up = "../../"){
            $http = new HttpRequest($up . "environment/environment.json");
            $environment = $http->getEnvironment();

            $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->usuari->read;
            $data = array('username' => $username, 'check' => true);
            $res = $http->makePostRequest($url, $data);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Email Exists
         *
         * @return boolean
         * 
         * Métode que envia una petició al backend per comprovar a la BBDD si l'email ja existeix
         */
        public static function emailExists($email, $up = "../../"){
            $http = new HttpRequest($up . "environment/environment.json");
            $environment = $http->getEnvironment();

            $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->usuari->read;
            $data = array('email' => $email, 'check' => true);
            $res = $http->makePostRequest($url, $data);
            if ($res) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Auth
         *
         * @return boolean
         * 
         * Métode que realitza la autenticació i crea una sessió si el login es exitós
         */
        public static function auth($id, $pwd, $up = "../../"){
            $http = new HttpRequest($up . "environment/environment.json");
            $environment = $http->getEnvironment();
            $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->usuari->read;

            $data = array(
                'login' => true,
                'identifier' => $id
            );
            
            $res = $http->makePostRequest($url, $data);
            
            if ($res !== null) {
                if($res->auth){
                    if(password_verify($pwd, $res->phash)){
                        session_regenerate_id(true);
                        $_SESSION = array();
                        $_SESSION['username'] = ucwords(strtolower($res->username));  
                        return true;
                    } else {
                        print "<h1 class='text-danger' style='text-align:center'>Contrasenya incorrecta</h1>";
                        return false;
                    }

                } else {
                    print "<h1 class='text-danger' style='text-align:center'>" . $res->missatge . "</h1>";
                    return false;
                }
            } else {
                print "<h1 class='text-danger' style='text-align:center'>Hi ha hagut un error amb el procés d'autenticació</h1>";
                return false;
            }
        }

        /**
         * User Exists
         *
         * @return boolean
         * 
         * Métode que envia una petició al backend per comprovar que un usuari existeix a la BBDD
         */
        public static function userExist($identifier, $up = "../../../"){
            $http = new HttpRequest($up . "environment/environment.json");
            $environment = $http->getEnvironment();
            $url = $environment->protocol . $environment->baseUrl . $environment->dir->modules->api->usuari->read;

            $data = array(
                'check' => true,
                'identifier' => $identifier
            );
            
            $res = $http->makePostRequest($url, $data);
            if ($res != null) {
                return $res;
            } else {
                return null;
            }
        }
    }
?>