<?php

App::uses('Component', 'Controller');

class WScomponent extends Component {

	public function changeCash($id_user, $num, $addFee=false){
		$this->User = ClassRegistry::init('User');
        $this->User->id = $id_user;

	    $cs = $this->User->find('first', array(
            'recursive' => -1, 
            'fields' => array('User.cash'), 
            'conditions' => array('User.id' => $id_user)
            ));
        
		if ($cs) {
		    if($addFee) $num = $num + $num * FEES_RATIO + FEES_FIX;
		    
		    if($num < 0){
		        // SUBTRACT MONEY
		        if($cs['User']['cash'] < abs($num)){
		            return false;
		        } else {
		            $this->User->saveField('cash', $cs['User']['cash'] + $num);
		            return true;
		        }
		    } else if ($num > 0) {
		        $this->User->saveField('cash', $cs['User']['cash'] + $num);
		        return true;
		    } else {
		        return true;
		    }
		}
	}
	
	public function changeBook($qty, $bk, $price = null){
	    // DON'T NEED PRICE TO SUBTRACT
		$this->Book = ClassRegistry::init('Book');
	    $this->Book->id = $bk['Book']['id'];

        if ($qty > 0){
			// ADD SOME STOCKS AND CHANGE AVERAGE
            if($price != null){
			    $average = ($qty * $price + $bk['Book']['quantity'] * $bk['Book']['average_price']) / ($bk['Book']['quantity'] + $qty);
        		$this->Book->save(array(
        			'quantity' => $bk['Book']['quantity'] + $qty,
        			'average_price' => round($average, 2)
        		));
        		return true;
            }else{
                // FOR THIS, YOU NEED A PRICE
                return false;
            }
		}else{
		    // SUBTRACT
			if($bk['Book']['quantity'] == abs($qty)){
			    // GET RID OF IT
				$this->Book->delete();
			} else if ($bk['Book']['quantity'] > -$qty){
			    // SUBTRACT THE QUANTITY
				$this->Book->saveField('quantity', $bk['Book']['quantity'] + $qty);
			} else {
	            // NOT ENOUGHT
	            $this->Session->setFlash(__('You\'re trying to sell something you don\'t possess! Try a smaller amount maybe...'));
	            return false;
			}
        	return true;
		}
	}
	public function addBook($qty, $price, $st_id, $us_id){
		$this->Book = ClassRegistry::init('Book');
    	if ($qty > 0){
    		$this->Book->create();
    		$this->Book->save(array(
    			'stock_id' => $st_id,
    			'user_id' => $us_id,
    			'quantity' => $qty,
    			'profit' => '0',
    			'average_price' => $price
    		));
    		return true;
    	} else {
    	    // MUST BE > 0
    	    return false;
    	}
	}
	
	public function checkStockInBook($id, $st_id){
		$this->Book = ClassRegistry::init('Book');
		return $this->Book->find('first', array('conditions' => array('stock_id' => $st_id,	'user_id' => $id)));
	    // RETURN FALSE IF NOTHING FOUND
	}
	
	// CHANGE SCORE
	
	// PUBLISH STORY
	
	// CHANGE STOCK VALUE

}

?>