<?php

App::uses('Controller', 'Controller');
App::uses('FB', 'Facebook.Lib');

class AppController extends Controller {
	public $helpers = array('Facebook.Facebook');

	public $components = array(
		'Facebook.Connect' => array('model' => 'User'),
        'Session',
        'Auth' => array(
    	        'authenticate' => array(
    	            'Form' => array(
    	                'fields' => array('username' => 'email')
    	            )
    	        ),
                'loginAction' => array('admin' => false, 'controller' => 'users', 'action' => 'login'),
                'loginRedirect' => array('controller' => 'pages', 'action' => 'home'),
                'logoutRedirect' => array('http://www.facebook.com/wildstocks/'),
                'authorize' => array('Controller')),
        'WS'
    );
   	public function beforeFilter() {

 		// $this->loadModel('Config');
 		// $this->set('config', $this->Book->find('all'));
 		// TODO Check for maintenance (make model)

		$this->set('_CURRENCY', '♉');
		
        $ss = $this->Session->read();
        
        if (!isset($ss['Auth']['User'])){
    		$this->loadModel('User');
            $this->User->create();
            $this->User->save(array(
                    'name' => 'guest #'.rand(0, 1000),
                    'cash' => 20000,
                    'yesterday_book_value' => '0',
                    'email' => 'test'.rand().'@test.com',
                    'role' => 'normal',
                    'help_steps' => json_encode(array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0)),
                    'facebook_id' => '10'
                ));
    		
    		$this->Session->write('Auth', $this->User->read(null, $this->User->getLastInsertId()));
		    $this->set('authUser', $this->Auth->user());
		  //  $this->updateAuth($this->User->getLastInsertId());
		    $this->resetHelpSteps();
            // pr('no session');
        } else {
            // pr('you have a session');
            $this->set('authUser', $this->Auth->user());
        }
		
        // STORE $_GET VALUE BEFORE LOGIN REDIRECT
        if(isset($this->request->query['request_ids'])){
            $this->Session->write('Get.request_ids', $this->request->query['request_ids']);
        }
        if(isset($this->request->query['error_reason']) && $this->request->query['error_reason'] == 'user_denied'){
            $this->redirect('http://www.facebook.com/wildstocks/');
        }

   	// 	$this->set('facebook_user', $this->Connect->user());
 		
 		
    	//
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin') {
            $this->layout = 'admin';
        } else if(isset($this->viewVars['authUser'])) {
            $this->layout = 'loggedin';
            $this->set('help_steps', json_decode($this->viewVars['authUser']['help_steps'], true));
        } else {
            $this->layout = 'default';
        }
        
        // $this->updateAuth();
        $this->resetHelpSteps();

 		// BOOK
        $this->updateBook();
        
		setlocale(LC_MONETARY, 'en_US');
		setlocale(LC_NUMERIC, 'en_US');

        // FRIEND LIST
        // $this->Session->destroy();
        /*if (!$this->Session->check('Friends.app_non_user')) {
            $this->getFriendsList();
        } else {
            $this->set('app_user', $this->Session->read('Friends.app_user'));
            $this->set('app_invited_user', json_decode($this->Session->read('Friends.app_invited_user')));
            $this->set('app_non_user', $this->Session->read('Friends.app_non_user'));
        }*/
    }

    public function isAuthorized($user = null) {
        // Any registered user can access public functions
        if (empty($this->request->params['admin'])) {
            return true;
        }
        // Only admins can access admin functions
        if (isset($this->request->params['admin'])) {
            return (bool)($user['role'] === 'admin');
        }
        // Default deny
        return false;
    }
    
   	public function beforeFacebookSave(){
	    $this->Connect->authUser['User']['email'] = $this->Connect->user('email');
	    $this->Connect->authUser['User']['name'] = $this->Connect->user('first_name');
	    return true;
	}
	
	public function beforeFacebookLogin(){

	}
	
	public function afterFacebookLogin(){
	   if($this->request->is('mobile') || IS_MOBILE){
            $this->redirect(array('controller' => 'mobile', 'action' => 'index'));
       } else {
            $this->redirect(array('controller' => 'pages', 'action' => 'home'));
       }
       
	}
	public function updateAuth(){
		$this->loadModel('User');
        $this->Session->write('Auth', $this->User->read(null, $this->viewVars['authUser']['id']));
        $this->set('authUser', $this->Auth->user());
	}
	
    public function updateHelp($num){
        if($num == 5){
            $this->viewVars['help_steps'][2] = 1;
            $this->viewVars['help_steps'][3] = 1;
            $this->viewVars['help_steps'][4] = 1;
            $this->viewVars['help_steps'][5] = 1;
            $this->WS->changeCash($this->viewVars['authUser']['id'], FTUE_BONUS);
        } else {
            $this->viewVars['help_steps'][$num] = 1;
        }
        $this->loadModel('User');
		$this->User->id = $this->viewVars['authUser']['id'];
        $this->User->saveField('help_steps', json_encode($this->viewVars['help_steps']));
        pr($this->viewVars['help_steps']);
        $this->updateAuth();
	}
	
	public function dtFormat($foo){
		return date('d/m', $foo);
	}

    public function updateBook(){
        $this->loadModel('Book');
        $this->set('myBooks', $this->Book->find('all', array('conditions' => array('Book.user_id' => $this->Auth->user('id')))));
                    
        $worth = 0;
        $bought = 0;
        foreach ($this->viewVars['myBooks'] as $book){
            $worth += $book['Stock']['value'] * $book['Book']['quantity'];
            $bought += $book['Book']['quantity'] * $book['Book']['average_price'];
        }
        $this->set('worth', round($worth,2));
        $this->set('bought', round($bought, 2));
        $this->set('profit', round($worth-$bought, 2));
    }
    
    public function resetHelpSteps(){
        $this->loadModel('User');
        $this->User->read(null, $this->viewVars['authUser']['id']);
        $this->User->set('help_steps', json_encode(array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0)));
        $this->User->save();
        $this->updateAuth();
    }
    
    public function getFriendsList(){
        $app_user = array();
        $app_invited_user = array();
        $app_non_user = array();
        
        // GET ALL FRIENDS
        // $friends = FB::api('me/friends?fields=installed,name','GET');
        
        $i = 0;
        $friends = FB::api('me/friends?fields=installed,name,apprequests.fields(application)&offset='. 250 * $i .'&limit=250','GET');
        
        if(isset($friends['data'])){
            // pr($friends);
            
            foreach ($friends['data'] as $friend) {
                if(isset($friend['installed'])){
                    $app_user[] = $friend['id'];
                }else{
                    if (isset($friend['apprequests']['data'])) {
                        $app_invited_user[] = $friend['id'];
                    }else{
                        $app_non_user[] = $friend['id'];
                    }
                }
            }
            // Remove invited friends
            $app_user = array_diff($app_user, $app_invited_user);
            $app_non_user = array_diff($app_non_user, $app_invited_user);

            $this->Session->write('Friends.app_user', json_encode($app_user));
            $this->Session->write('Friends.app_invited_user', json_encode($app_invited_user));
            $this->Session->write('Friends.app_non_user', json_encode(array_slice($app_non_user, 0, 50)));
            $this->set('app_user', json_encode($app_user));
            $this->set('app_invited_user', $app_invited_user);
            $this->set('app_non_user', json_encode(array_slice($app_non_user, 0, 50)));

            $i++;
        }
    }
}

