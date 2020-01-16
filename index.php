<?php         
    require_once(dirname(__FILE__).'/config.php');
    require_once(dirname(__FILE__).'/lib/rest.php');

    $esdersRest = new REST();
    echo $esdersRest->getJson();
    
?>
