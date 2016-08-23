<?php

if(env('SERVER_NAME') == PROD_SERVER){
    // PROD
    $config = array(
        'Facebook' => array(
            'appId'  => '',
            'apiKey' => '',
            'secret' => '',
            'cookie' => true,
            'locale' => 'en_US',
        )
    );
} else {
    // DEV
    $config = array(
        'Facebook' => array(
            'appId'  => '',
            'apiKey' => '',
            'secret' => '',
            'cookie' => true,
            'locale' => 'en_US',
        )
    );
}


?>