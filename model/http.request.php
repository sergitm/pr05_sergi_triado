<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    class HttpRequest {

        private $environment;

        // CONSTRUCTOR
        public function __construct($env_url){
            $env = json_decode(file_get_contents($env_url));
            $this->environment = $env->environment;
        }

        // GETTER
        public function getEnvironment(){
            return $this->environment;
        }
        
        /**
         * Make Get Request
         *
         * @return resultat
         * 
         * Métode per fer peticions HTTP GET
         */
        public function makeGetRequest($url, $values = null){ 
            $params = "";

            if ($values !== null) {
                $params += "?";
                $paramsArr = array();
                foreach ($values as $key => $value) {
                    array_push($paramsArr, $key . '=' . $value); 
                }
                implode('&', $paramsArr);
                $params += $paramsArr;
            }

            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'GET'
                )
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url . $params, false, $context);

            return $result;
        }
        /**
         * Make Post Request
         *
         * @return resultat
         * 
         * Métode per fer peticions HTTP POST
         */
        public function makePostRequest($url, $data){

            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            
            $context  = stream_context_create($options);
            $result = json_decode(file_get_contents($url, false, $context));
            
            return $result;
        }      
    }
?>