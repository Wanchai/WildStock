<?php
App::uses('AppController', 'Controller');

class StocksController extends AppController {
    
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('fb_feed');
    }
    
	public function index() {
	    
		$this->Stock->recursive = 0;
        $this->paginate = array(
            'order' => array('Stock.name' => 'asc'),
            'limit' => 50
        );
		$this->set('stocks', $this->paginate());

		// CALCULATE VARIATION
		foreach ($this->viewVars['stocks'] as $req){
			
			$var = round(($req['Stock']['value']-$req['Stock']['yesterday']) * 100 / $req['Stock']['yesterday'], 2);
			if ($var != $req['Stock']['variation']){
				$this->Stock->id = $req['Stock']['id'];
				$this->Stock->saveField('variation', $var);
			}
		}
		
		// STALLIONS & MULES
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
	}   
	
	public function view($id = null) {
		
		$this->Stock->id = $id;
		if (!$this->Stock->exists()) {
			throw new NotFoundException(__('Invalid stock'));
		}
		$this->set('stock', $this->Stock->read());
		
		// SPLIT THE OFFERS
	    $offers = $this->Stock->Offer->find('all', array(
            'conditions' => array('Stock.id' => $id),
            'recursive' => '0'
        ));
        
		$buy = array();
		$sell = array();
		$mybuy = array();
		$mysell = array();
		
		foreach($offers as $st){
		    if($st['Offer']['type'] === 1){
		        if($st['Offer']['user_id'] == $this->viewVars['authUser']['id']){
		            $mybuy[] = $st['Offer'];
		        }else{
		            $buy[] = $st['Offer'];
		        }
		    } else if($st['Offer']['type'] === 2){
		        if($st['Offer']['user_id'] == $this->viewVars['authUser']['id']){
		            $mysell[] = $st['Offer'];
		        }else {
		            $sell[] = $st['Offer'];
		        }
		    }
		}
		
		$this->set('buy_offers', $this->sort_by_closest($buy, $this->viewVars['stock']['Stock']['value']));
		$this->set('sell_offers', $this->sort_by_closest($sell, $this->viewVars['stock']['Stock']['value']));
		$this->set('mybuy_offers', $mybuy);
		$this->set('mysell_offers', $mysell);
		
		// CHECK MY PORTFOLIO FOR THIS STOCK
        $mine = "";
        foreach($this->viewVars['myBooks'] as $bk){
            if ($bk['Book']['stock_id'] == $id){
                $mine = $bk['Book'];
            }
        }
		$this->set('mine', $mine);
	}
	
	public function sort_by_closest($arr, $num){
	    if($arr){
	        // Store a Key => Price association and sort by price
            foreach ($arr as $k => $v){ 
                $diff[] = array('key' => $k, 'num' => abs($v['price'] - $num)); 
            }
            $diff = Set::sort($diff, '{n}.num', 'asc');
            foreach ($diff as $k => $v){
                $array2[$k] = $arr[$v['key']];
            }
            return $array2;
	    }else{
	        return $arr;
	    }
	}
	
	public function admin_index() {
	    
		$this->Stock->recursive = 0;
		$this->set('stocks', $this->paginate());
	}
	
	public function admin_view($id = null) {
	    
		$this->Stock->id = $id;
		if (!$this->Stock->exists()) {
			throw new NotFoundException(__('Invalid stock'));
		}
		$this->set('stock', $this->Stock->read(null, $id));
	}

	public function admin_add() {
	    
		if ($this->request->is('post')) {
			$this->Stock->create();
			if ($this->Stock->save($this->request->data)) {
				$this->Session->setFlash(__('The stock has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The stock could not be saved. Please, try again.'));
			}
		}
		$categories = $this->Stock->Category->find('list');
		$this->set(compact('categories'));
	}

	public function admin_edit($id = null) {
	    
		$this->Stock->id = $id;
		if (!$this->Stock->exists()) {
			throw new NotFoundException(__('Invalid stock'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Stock->save($this->request->data)) {
				$this->Session->setFlash(__('The stock has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The stock could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Stock->read(null, $id);
		}
		$categories = $this->Stock->Category->find('list');
		$this->set(compact('categories'));
	}

	public function admin_delete($id = null) {
	    
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Stock->id = $id;
		if (!$this->Stock->exists()) {
			throw new NotFoundException(__('Invalid stock'));
		}
		if ($this->Stock->delete()) {
			$this->Session->setFlash(__('Stock deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Stock was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>