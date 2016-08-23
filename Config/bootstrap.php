<?php

/** CONSTANTS **/

define('LOCAL_SERVER', 'dev-liz.com');
define('TEST_SERVER', 'ws-experiment.herokuapp.com');
define('PROD_SERVER', 'ws-deploy.herokuapp.com');
// define('PROD_SERVER', 'game.wildstocks-game.com');
define('TAUR', '<b>♉</b>'); // UNICODE 2649
define('BEST_PERF_LIMIT', '4');
define('FEES_FIX', '2');
define('FEES_RATIO', '0.01');
define('LIKE_BONUS', '1500');
define('INVIT_BONUS', '100');
define('FTUE_BONUS', '1000');

if(env('SERVER_NAME') == PROD_SERVER){
    // PROD
    define('IS_MOBILE', false);
    
    // Avoid to redirect to http://
    Router::fullBaseUrl('https://'.PROD_SERVER);

} else if (env('SERVER_NAME') == TEST_SERVER) {
    // TEST
    define('IS_MOBILE', false);
    
    Router::fullBaseUrl('https://'.TEST_SERVER);
    
} else if (env('SERVER_NAME') == LOCAL_SERVER) {
    
    // DEV
    define('IS_MOBILE', false);
    
}

/** FUNCTIONS **/

function colorNumber($num, $percent = true){
	if($num == 0) {
		return '--';
	} else if($num > 0) {
		return '<span style=color:#40d400>+'. splitNumber($num).($percent?'%':'').'</span>'; 	
	} else {
		return '<span style=color:#ff0000>'. splitNumber($num).($percent?'%':'').'</span>'; 	
	}
}

function splitNumber($num) {
    if ($num > 10000){
    	if ($num > 10000000){
    		$ret = number_format(round($num/1000), '0', '.', ' ');
    	}else{
    		$ret = round($num/1000);
    	}
        return $ret.' K';
    } else {
        return $num;
    }
}

function formatMoney($num){
	return TAUR.splitNumber($num);
}

// For the news
function makeLink($txt){
    $pieces = explode(" ", $txt);
    $output = "";
    
    foreach ($pieces as $pc){
    	if(!strstr($pc, 'http://') && !strstr($pc, 'https://')){
    		$output .= $pc." " ;
    	}else{
    		$output .= "<a href='$pc'>Link</a> ";
    	}
    }
    return $output;
}

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

CakePlugin::load('Facebook');

Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'FileLog',
	'scopes' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'FileLog',
	'scopes' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));


