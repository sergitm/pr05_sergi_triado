<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
$env = json_decode(file_get_contents("../../environment/environment.json"));
$environment = $env->environment;
$url = $environment->protocol . $environment->baseUrl;


setcookie(session_name(),'',0,'/');
session_destroy();
session_write_close();

header('Location: ' . $url);

?>