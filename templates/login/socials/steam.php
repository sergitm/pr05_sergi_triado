<?php
/**
*
* @author: Sergi Triadó <s.triado@sapalomera.cat>
*
*/
    include "../../../public/lib/hybridauth-3.8.2/src/autoload.php";
    include "../../../model/http.request.php";

    $http = new HttpRequest("../../../environment/environment.json");
    $environment = $http->getEnvironment();

    $config = [
        'callback' => $environment->protocol . $environment->baseUrl . $environment->dir->templates->socials->steam,
        'keys' => [ 'secret' => '5B3ABB804DFECA8CCA2153A9944F8186']
    ];

    $adapter = new \Hybridauth\Provider\Steam($config);
    
    try {
        $adapter->authenticate();
        $userProfile = $adapter->getUserProfile();

        $_SESSION['username'] = $userProfile->displayName;

        header("Location: " . $environment->protocol . $environment->baseUrl);
    } catch (\Exception $e) {
        echo $e->getMessage() ;
    }

    
?>