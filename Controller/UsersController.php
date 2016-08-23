<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}
	
	public function me(){
	    $this->updateAuth();
	    $this->User->id = $this->viewVars['authUser']['id'];
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->find('first', array(
			'recursive' => 1,
			'conditions' => array('User.id' => $this->viewVars['authUser']['id'])
			)));
		
		/* TRANSACTIONS */
		$tab = array();
		foreach($this->viewVars['user']['SellTransac'] as $tr){
		    $tab[] = $tr;
		}
		foreach($this->viewVars['user']['BuyTransac'] as $tr){
		    $tab[] = $tr;
		}
		$tab = Set::sort($tab, '{n}.date', 'desc');
		$this->set('transactions', $tab); 
		
		/* PICTURE */
	    $pic = FB::api('me?fields=picture.type(normal)','GET');
	    $this->set('pic', $pic['picture']['data']['url']);
	    
	    /* LIKE */ 
	    if(!$this->viewVars['authUser']['like_page']){
	        $lk = FB::api('me/likes?fields=name&target_id=138716626294650','GET');
	        if(count($lk['data']) === 1){
	            $this->User->id = $this->viewVars['authUser']['id'];
	            $this->User->saveField('like_page', true);
	            $this->WS->changeCash($this->viewVars['authUser']['id'], LIKE_BONUS);
		        $this->updateAuth();
	        }
	    }
	}

	public function login() {
		if($this->request->is('mobile') || IS_MOBILE){
			$this->redirect(array('controller' => 'mobile', 'action' => 'login'));
		}

	    if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	            $this->redirect($this->Auth->redirect());
	        } else {
	            $this->Session->setFlash(__('Invalid username or password, try again'));
	        }
	    }
	}
    
    public function logout() {
	    $this->redirect($this->Auth->logout());
	}
    
    /**
     * ADMIN
     */
   	public function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	public function admin_view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
	}

	public function admin_edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
	}

	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
 }