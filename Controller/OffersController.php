<?php
App::uses('AppController', 'Controller');

class OffersController extends AppController {

	public function index() {
		/*$this->Offer->recursive = 0;
		$this->paginate = array(
			'order' => array('Offer.date' => 'desc'),
			'limit' => '40'
		);		
		$this->set('buy', $this->paginate('Offer', array('type_id' => 2)));
		$this->set('sell', $this->paginate('Offer', array('type_id' => 1)));*/
	}
	
	public function add(){
        if ($this->request->is('post')) {
	        
            $id = $this->request->data['Offer']['stock_id'];
            $req = $this->request->data;
            
            $ref = $this->request->data['Offer']['ref'];
			
			$this->Offer->set($req);
			
			// VALIDATE FIRST
			if ($this->Offer->validates()) {			    
			    
				if($req['Offer']['quantity'] <= 0 || $req['Offer']['price'] <= 0){
					$this->Session->setFlash(__('You can\'t put zero in price or quantity!'));
					$this->redir($ref);
				}
	
				if ($req['Offer']['type'] == 2){
					// I SELL SOME STOCKS (BOOK - STOCKS)
					// CHECK IF I HAVE THE SPECIFIED STOCK
					$bk = $this->WS->checkStockInBook($this->viewVars['authUser']['id'], $req['Offer']['stock_id']);
					
					if($bk){
					    $this->WS->changeBook(-$req['Offer']['quantity'], $bk);
					}else{
						$this->Session->setFlash(__('You don\'t have that kind of stock.'));
						$this->redir($ref);
					}
				} else if ($req['Offer']['type'] == 1){
					// BUY (CASH - COST)
				    $cost = $req['Offer']['quantity'] * $req['Offer']['price'];
				 	if(!$this->WS->changeCash($this->viewVars['authUser']['id'], -$cost, true)){
				 	    $this->Session->setFlash(__('You don\'t have enough cash.'));
						$this->redir($ref);
				 	}else{
						$this->updateAuth();
				 	}
				} else {
				    $this->Session->setFlash(__('Error with your transaction. Please, try again.'));
				    $this->redir($ref);
				}
	
				$this->Offer->create();
				if ($this->Offer->save($req)) {
					$this->Session->setFlash(__('The offer has been saved'));
				} else {
					$this->Session->setFlash(__('The offer could not be saved. Please, try again.'));
				}
				$this->redir($ref);
			
			} else {
				// NOT VALIDATED
			    $this->Session->setFlash(__('Errors with your inputs. Please, try again.'));
			    $this->redir($ref);
			}
		}
	}
	
	/*
	* Change the quantity in an offer and:
	* - dispatch stocks and cash accordingly
	* - add a transaction entry
	* - FB:change the score
	* - FB:post story
	*
	*/
	public function change($offid = null) {
	    if ($this->request->is('post')) :
	    if($offid){
	       $id = $offid;
	    } else if ($this->request->data['Offer']) {
	        $id = $this->request->data['Offer']['id'];
	    }else{
	        $this->Session->setFlash(__('We have a problem, but I don\'t know what it is ...'.print_r($this->request->data['Offer'], true)));
			$this->redirect(array('controller' => 'pages', 'action' => 'home'));
	    }
	    
	    $ref = $this->request->data['Offer']['ref'];
	    $req = $this->Offer->find('first', array('recursive' => 0, 'conditions' => array('Offer.id' => $id)));
	    
		if (!$req) {
			throw new NotFoundException(__('Invalid offer. Maybe it\'s not available anymore! '.$id));
		}
		
		$offer = $req['Offer'];
		$user = $req['User'];
		$stock = $req['Stock'];
		$change = $this->request->data['Offer'];
		$change['quantity'] = $this->request->data['transac_qty'];
		
		// CHECK QUANTITY MATCH ON TRANSACTION
		if($change['quantity'] <= 0){
			$this->Session->setFlash(__('C\'mon, try a little bit more!'));
			$this->redir($ref);
		}
		
		// ON A SELL OFFER I'M THE BUYER
		if($offer['type'] == 2){
            // CHECK QUANTITY
            if($offer['quantity'] < $change['quantity']){
			    $this->Session->setFlash(__('Not enough stocks on seller\'s offer.'));
			    $this->redir($ref);
		    }            
			// CHECK & CHANGE THE CASH AMOUNT FOR USERS
			$cost = $change['quantity'] * $offer['price'];
			if(!$this->WS->changeCash($this->viewVars['authUser']['id'], -$cost, true)){
				$this->Session->setFlash(__('You don\'t have enough cash!'));
				$this->redir($ref);
			}
			$this->updateAuth();
			// SELLER
			$this->WS->changeCash($offer['user_id'], $cost);

			// ADD TO MY BOOKS
			$buyer_book = $this->WS->checkStockInBook($this->viewVars['authUser']['id'], $offer['stock_id']);

			if($buyer_book){
			    $this->WS->changeBook($change['quantity'], $buyer_book, $offer['price']);
			} else {
			    $this->WS->addBook($change['quantity'], $offer['price'], $offer['stock_id'], $this->viewVars['authUser']['id']);
			}
			$this->updateBook();
			
			// CHANGE THE STOCK VALUE
			$transac = array(
				'Stock' => array(
					'id' => $offer['stock_id'],
					'value' => $offer['price'],
					'variation' => $offer['price'] - $stock['yesterday']
				),
				'Transaction' => array(
					'buyer_id' => $this->viewVars['authUser']['id'] , 
					'seller_id' => $offer['user_id'] , 
					'stock_id' => $offer['stock_id'],
					'stock_name' => $offer['stock_name'], 
					'quantity' => $change['quantity'] , 
					'value' => $offer['price'], 
					'date' => date('Y-m-d H:i:s')
				)    
            );
            
            // PUBLISH WORTH VALUE AS FACEBOOK SCORE
            
            // TODO Store score to avoid FB Req
            
            /*$score = FB::api('me/scores','GET');
            $score = (isset($score['data'][0]['score'])) ? $score['data'][0]['score'] : false ;
            
            if(!$score || $score < $this->viewVars['worth']){
                $response = FB::api('me/scores', 'POST', array('score' => $this->viewVars['worth']));
            }*/
            
            // PUBLISH STORY ON FACEBOOK
            /*if(Configure::read('debug') < 1){
                $response = FB::api('me/wildstocks:buy', 'POST', array(
                    'stock' => "https://apps.facebook.com/wildstocks/stocks/fb_feed/".$offer['stock_id']
                 ));
            }*/
            
		} else if ($offer['type'] == 1) {
		    // ON A BUY OFFER THE BUYER IS THE OFFER USER - SELLER IS ME
            if($offer['quantity'] < $change['quantity']){
			    $this->Session->setFlash(__('It\'s too much stocks for this offer.'));
			    $this->redir($ref);
		    } 

			// BOOKS
			$seller_book = $this->WS->checkStockInBook($this->viewVars['authUser']['id'], $offer['stock_id']);
			
			if($seller_book){
				// REMOVE FROM MY BOOKS //
				if(!$this->WS->changeBook(-$change['quantity'], $seller_book)){
					$this->Session->setFlash(__('You\'re trying to sell something you don\'t possess! Try a smaller amount maybe...'));
					$this->redir($ref);
				}
				$this->updateBook();
				
			    $buyer_book = $this->WS->checkStockInBook($offer['user_id'], $offer['stock_id']);
				// ADD TO BOOKS //
				if($buyer_book){
				    $this->WS->changeBook($change['quantity'], $buyer_book, $offer['price']);
				} else {
				    $this->WS->addBook($change['quantity'], $offer['price'], $offer['stock_id'], $offer['user_id']);
				}

				// GIVE ME MY CASH !!!
				$this->WS->changeCash($this->viewVars['authUser']['id'], $change['quantity'] * $offer['price']);
			    $this->updateAuth();
			} else {
				$this->Session->setFlash(__('You don\'t seem to have that kind of stock!'));
		        $this->redir($ref);
			}

			// CHANGE THE STOCK VALUE
			$transac = array(
				'Stock' => array(
					'id' => $offer['stock_id'],
					'value' => $offer['price'],
					'variation' => $offer['price'] - $stock['yesterday']
				),
				'Transaction' => array(
					'buyer_id' => $offer['user_id'] , 'seller_id' => $this->viewVars['authUser']['id'] , 'stock_id' => $offer['stock_id'],
					'stock_name' => $offer['stock_name'], 'quantity' => $change['quantity'] , 'value' => $offer['price'], 'date' => date('Y-m-d H:i:s')
				)
			);
		} else {
		    throw new NotFoundException(__('Invalid offer type!'));
		}

		// DELETE THE OFFER OR DEDUCT THE QUANTITY FROM THE OFFER
		if($offer['quantity'] == $change['quantity']){
			$this->Offer->delete($id);
            
            // SEND NOTIFICATION TO OFFER'S OWNER
            $token_url = "https://graph.facebook.com/oauth/access_token?" .
                "client_id=" .FB::getAppId().
                "&client_secret=" .FB::getApiSecret().
                "&grant_type=client_credentials";
            $app_token = file_get_contents($token_url);
            
            $res = FB::api(
                $user['facebook_id'].'/notifications',
                'POST',
                array(
                    'access_token' => str_replace("access_token=", "", $app_token),
                    'href' => '', 
                    'template'=> __('Offering completed for: %s at %s', $stock['name'], $offer['price'])
                ));
		} else {
			$this->Offer->id = $id;
			$this->Offer->saveField('quantity', $offer['quantity'] - $change['quantity']);
		}

		$this->loadModel('Transaction');
		$this->Transaction->saveAssociated($transac);
		$this->Session->setFlash(__('Transaction done'));
        
		$this->redir($ref);
		
		endif;
	}
	
	/*
	* REDIR
	*
	*/
	
	public function redir($var){
	    $this->redirect($var);
	}

    /* Send 'st_id=stock_id' if you stock specific delete or 
    *  'all' for all offers of the active user 
    *  'ref' is the page to redirect to 
    */
	public function delete_all_mine(){
		if(!$_GET['ref']) throw new MethodNotAllowedException(__('You can\'t do that!'));
		
		$tab = array('Offer.user_id' => $this->viewVars['authUser']['id']);
		// CHECK FOR stock specific delete or all of user's offers
		if($_GET['st_id'] != 'all') $tab['Offer.stock_id'] = $_GET['st_id'];
		
		$toDel = $this->Offer->find('all', array('conditions' => $tab, 'recursive' => -1, 'fields' => array('Offer.id')));
        
        foreach ($toDel as $do) {
            $this->delete($do['Offer']['id']);
        }
        $this->updateAuth();
        
		$this->Session->setFlash(__('Offers deleted!'));
		$this->redirect($_GET['ref']);
	}
	
	/* There's 2 way to delete an offer :
	* - by user's request
	* - because it has been honored
	*/ 
	public function delete($id, $user_request = false){
	    
		$this->Offer->id = $id;
		$delOffer = $this->Offer->find('first', array('conditions' => array('Offer.id' => $id)));
		if (!$delOffer) {
			throw new NotFoundException(__('Invalid offer'));
		}
	    
        // GET THE BOOK OF THIS USER'S OFFER
		$boo = $this->Book->find('first', array('conditions' => array(
		    'stock_id' => $delOffer['Offer']['stock_id'], 
		    'user_id' => $this->viewVars['authUser']['id'])
	    ));
	    
		if ($this->Offer->delete()) {
			if ($delOffer['Offer']['type'] == 1) {
				// GET THE MONEY BACK
				$this->WS->changeCash($delOffer['Offer']['user_id'], $delOffer['Offer']['quantity'] * $delOffer['Offer']['price']);
			} else if ($delOffer['Offer']['type'] == 2) {
	   			// GET STOCKS BACK
	   			if(count($boo) === 0){
                    $avg = ($delOffer['Offer']['bought'] == NULL) ? '0' : $delOffer['Offer']['bought'];
	   		    	// IF THIS KIND OF STOCK IS NOT IN THE BOOK ANYMORE
	   			    $this->Book->create();
					$this->Book->save(array(
						'profit' => '0',
						'stock_id' => $delOffer['Offer']['stock_id'],
						'user_id' => $delOffer['Offer']['user_id'],
						'quantity' => $delOffer['Offer']['quantity'],
						'average_price' => $avg
					));
	   			} else {
	   			    // ADD UP TO THE EXISTING
	   		     	$this->Book->id = $boo['Book']['id'];
	   		    	$this->Book->saveField('quantity', $boo['Book']['quantity'] + $delOffer['Offer']['quantity']);
	   			}
			}
// 			$this->Session->setFlash(__('Offer deleted'));
			//$this->redirect(array('action' => 'index'));
		}
// 		$this->Session->setFlash(__('Offer was not deleted'));
		//$this->redirect(array('action' => 'index'));
	}
	
	public function admin_index() {
		$this->Offer->recursive = 0;
		$this->set('offers', $this->paginate());
	}

	public function admin_view($id = null) {
		$this->Offer->id = $id;
		if (!$this->Offer->exists()) {
			throw new NotFoundException(__('Invalid offer'));
		}
		$this->set('offer', $this->Offer->read(null, $id));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Offer->create();
			if ($this->Offer->save($this->request->data)) {
				$this->Session->setFlash(__('The offer has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The offer could not be saved. Please, try again.'));
			}
		}
		$users = $this->Offer->User->find('list');
		$stocks = $this->Offer->Stock->find('list');
		$this->set(compact('users', 'stocks'));
	}

	public function admin_edit($id = null) {
		$this->Offer->id = $id;
		if (!$this->Offer->exists()) {
			throw new NotFoundException(__('Invalid offer'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Offer->save($this->request->data)) {
				$this->Session->setFlash(__('The offer has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The offer could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Offer->read(null, $id);
		}
		$users = $this->Offer->User->find('list');
		$stocks = $this->Offer->Stock->find('list');
		$this->set(compact('users', 'stocks'));
	}

	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Offer->id = $id;
		if (!$this->Offer->exists()) {
			throw new NotFoundException(__('Invalid offer'));
		}
		
		$delOffer = $this->Offer->read();
        // GET THE BOOK OF THIS USER'S OFFER
		$boo = $this->Book->find('first', array(
	        'conditions' => array('stock_id' => $delOffer['Offer']['stock_id'], 'user_id' => $delOffer['Offer']['user_id'])
	    ));
	    
		if ($this->Offer->delete()) {
			if ($delOffer['Offer']['type'] == 1) {
				// GET MONEY BACK
				$this->WS->changeCash($delOffer['Offer']['user_id'], $delOffer['Offer']['quantity'] * $delOffer['Offer']['price']);
			} else if ($delOffer['Offer']['type'] == 2) {
	   			// GET STOCKS BACK
	   			if(count($boo) === 0){
	   		    	// IF THIS KIND OF STOCK IS NOT IN THE BOOK ANYMORE
	   			    $this->Book->create();
					$this->Book->save(array(
						'stock_id' => $delOffer['Offer']['stock_id'],
						'user_id' => $delOffer['Offer']['user_id'],
						'quantity' => $delOffer['Offer']['quantity'],
						'average_price' => $delOffer['Offer']['bought']
					));
	   			} else {
	   			    // ADD UP TO THE EXISTING
	   		     	$this->Book->id = $boo['Book']['id'];
	   		    	$this->Book->saveField('quantity', $boo['Book']['quantity'] + $delOffer['Offer']['quantity']);
	   			}
			}
			$this->Session->setFlash(__('Offer deleted'));
			$this->redirect(array('action' => 'index'));
            // return true;
		}
		$this->Session->setFlash(__('Offer was not deleted'));
		$this->redirect(array('action' => 'index'));
        // return false;
	}
}