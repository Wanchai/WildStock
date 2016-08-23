<?php

App::uses('AppController', 'Controller');

class TestsController extends AppController {

	public function index(){
        $this->layout = 'test';

		//$this->loadModel('Offer');
		
// 		$this->set('output', '');

        
        
		$this->set('output', '');
	}
	
	public function tweet(){
        $url = 'https://api.twitter.com/1/statuses/oembed.json?id=402747695573389312';
        $url .= '&omit_script=true';
        
        $info = file_get_contents($url);
        $info = json_decode($info, true);
        $info = $info['html'];
        $info = strip_tags($info);
        
        print_r($info);
	}

	public function fb() {

		$this->set('output', $this->Test->findById(2));

		$this->loadModel('Fbrequest');

		$clicked = $this->Fbrequest->find('all', array(
	        		'conditions' => array(
	        			'Fbrequest.user_id' => 2,
	        			'Fbrequest.touser_id' => 33,
	        			'Fbrequest.checked' => 1
	        			)
	        	));

		$this->set('req',$clicked);
	}
}

?>