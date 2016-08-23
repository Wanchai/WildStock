<?php

class PagesController extends AppController {

	public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('*');
    }
	public $uses = array();

	public function display() {
		$this->layout = 'default';

		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage'));
		$this->set('title_for_layout', $title);
		$this->render(implode('/', $path));
	}
	public function home(){
        
        // TUTORIAL
        // pr($this->viewVars['authUser']['help_steps']);
        if($this->viewVars['authUser']['help_steps'] == '0'){
            $this->Book->User->read(null, $this->viewVars['authUser']['id']);
            $this->Book->User->set('help_steps', json_encode(array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0)));
            $this->Book->User->save();
            $this->updateAuth();
            $this->set('help_steps', array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0));
        }
        
		// STALLIONS & MULES
        $this->loadModel('Stock');
        $this->set('best', $this->Stock->find('all', array(
            'order' => 'Stock.variation DESC', 
            'limit' => BEST_PERF_LIMIT,
            'recursive' => '-1'
        )));
        $this->set('worst', $this->Stock->find('all', array(
            'order' => 'Stock.variation ASC', 
            'limit' => BEST_PERF_LIMIT,
            'recursive' => '-1'
        )));
        
        // NEWS
        $this->loadModel('News');
        $this->set('news_feed', $this->News->find('all', array('order' => 'News.created DESC', 'limit' => '10')));
    
        // CHECK FOR REQUESTS 
        if($this->Session->check('Get.request_ids')){
        	$tab = explode(',',$this->Session->read('Get.request_ids'));
        	$this->loadModel('Fbrequest');
        	$this->loadModel('User');

        	foreach ($tab as $key => $value) {
               // DELETE the invite from Facebook
        		FB::api($value.'_'.$this->viewVars['authUser']['facebook_id'], 'DELETE');
        		
        		// RETRIBUTION TO THE INVITE SENDER
        		$found = $this->Fbrequest->find('first', array(
        		'conditions' => array(
        			'Fbrequest.request_id' => $value,
        			'Fbrequest.touser_id' => $this->viewVars['authUser']['id'],
        			'Fbrequest.checked' => 0
        			)
        		));

        		if($found){
        			$this->User->id = $found['User']['id'];
        			$this->User->saveField('cash', $found['User']['cash'] + INVIT_BONUS);
        			$this->Fbrequest->id = $found['Fbrequest']['id'];
        			$this->Fbrequest->saveField('checked', 1);
        		}
        	}
        	$this->Session->delete('Get.request_ids');          
        }
	}
	
    public function shop(){
        
    }
    
    public function helpStep($num){
        $this->updateHelp($num);
        $this->redirect($_GET['redir']);
    }
}


