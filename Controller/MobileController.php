<?php
App::uses('AppController', 'Controller');

class MobileController extends AppController {

	public function beforeFilter() {
        parent::beforeFilter();
		$this->layout = 'mobile';
		$this->Auth->allow('login');
    }

	public function index() {
		
		// STALLIONS & MULES
        $this->set('best', $this->Mobile->find('all', array(
            'order' => 'Mobile.variation DESC', 
            'limit' => BEST_PERF_LIMIT,
            'recursive' => '-1'
        )));
        $this->set('worst', $this->Mobile->find('all', array(
            'order' => 'Mobile.variation ASC', 
            'limit' => BEST_PERF_LIMIT,
            'recursive' => '-1'
        )));

	}
	public function stocks() {
	    
	    $this->Mobile->recursive = 0;
        $this->paginate = array(
            'order' => array('Mobile.name' => 'asc'),
            'limit' => 50
        );
		$this->set('stocks', $this->paginate());

		// CALCULATE VARIATION
		foreach ($this->viewVars['stocks'] as $req){
			
			$var = round(($req['Mobile']['value']-$req['Mobile']['yesterday']) * 100 / $req['Mobile']['yesterday'], 2);
			if ($var != $req['Mobile']['variation']){
				$this->Mobile->id = $req['Mobile']['id'];
				$this->Mobile->saveField('variation', $var);
			}
		}
	}
	
	public function stock($id) {
		$this->Mobile->id = $id;
		if (!$this->Mobile->exists()) {
			throw new NotFoundException(__('Invalid stock'));
		}
		$this->set('stock', $this->Mobile->read());
		
		// SPLIT THE OFFERS
		$this->loadModel('Offer');
	    $offers = $this->Offer->find('all', array(
            'conditions' => array('Offer.stock_id' => $id),
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
		
		$this->set('buy_offers', $this->sort_by_closest($buy, $this->viewVars['stock']['Mobile']['value']));
		$this->set('sell_offers', $this->sort_by_closest($sell, $this->viewVars['stock']['Mobile']['value']));
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
	
	public function me() {

	}
	
	public function about() {

	}
	
	public function login() {
	    //pr($this->Auth->login());
	   // if ($this->Auth->login()) {
	   //     debug('ok');
	   // }

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
}

?>
