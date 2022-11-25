<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    require_once "http.request.php";

    class Validator{

        public static function usernameExists($username){
            $http = new HttpRequest("../../environment/environment.json");
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

        public static function emailExists($email){
            $http = new HttpRequest("../../environment/environment.json");
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

        public static function auth($id, $pwd){
            $http = new HttpRequest("../../environment/environment.json");
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

        public static function userExist($identifier){
            $http = new HttpRequest("../../../environment/environment.json");
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