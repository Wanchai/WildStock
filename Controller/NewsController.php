<?php
App::uses('AppController', 'Controller');

class NewsController extends AppController {
    
    public function index(){
        $this->set('news', $this->News->find('all', array('order' => 'News.created DESC')));
    }
    
    public function admin_index(){
        $this->set('news', $this->News->find('all', array('order' => 'News.created DESC')));
    }
    
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->News->id = $id;
		if (!$this->News->exists()) {
			throw new NotFoundException(__('Invalid index'));
		}
		if ($this->News->delete()) {
			$this->Session->setFlash(__('News deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('News was not deleted'));
		$this->redirect(array('action' => 'index'));
    }
    
    public function admin_grab(){
        if ($this->request->is('post')) {
            
            $url = 'https://api.twitter.com/1/statuses/oembed.json?id='.$this->request->data['News']['number'];
            $url .= '&omit_script=true';
            
            // GET THE MESSAGE PART
            if($info = file_get_contents($url)){
                $info = json_decode($info, true);
                $info = $info['html'];
                // KEEP ONLY THE MESSAGE
                $info = strip_tags($info);
                // find — to clear the end of the msg
                $info = strstr($info, '&mdash;', true);
                // Make links
                $info = makeLink($info);
                
                $this->News->create();
                $this->News->save(array('text' => $info, 'tweet' => $this->request->data['News']['number']));
                
                $this->Session->setFlash(__('The news has been saved'));
                $this->redirect(array('action' => 'index'));
            }else{
                throw new NotFoundException(__('No tweet with this code!'));
            }
        }
    }
}