<?php

App::uses('AppController', 'Controller');

class FuncController extends AppController {

	public function admin_index($arg = null){
        if($arg == "reset_friendslist"){
            $this->adminGetFriendsList();
        }
	}
	
	public function admin_delete_old_offers() {
	    $this->loadModel('Offer');
        $i = 0;
        foreach($this->Offer->find('all', array('conditions' => array('date < ' => date('Y-m-d H:i:s', strtotime('30 days ago'))))) as $of){

            $delOffer = $of['Offer'];
            $this->Offer->id = $delOffer['id'];
            
            // GET THE BOOK OF THIS USER'S OFFER
            $boo = $this->Book->find('first', array('conditions' => array(
                'stock_id' => $delOffer['stock_id'], 
                'user_id' => $this->viewVars['authUser']['id'])
            ));
            
            if ($this->Offer->delete()) {
                if ($delOffer['type'] == 1) {
                    // GET THE MONEY BACK
                    $this->WS->changeCash($delOffer['user_id'], $delOffer['quantity'] * $delOffer['price']);
                } else if ($delOffer['type'] == 2) {
                    // GET STOCKS BACK
                    if(count($boo) === 0){
                        $avg = ($delOffer['bought'] == NULL) ? '0' : $delOffer['bought'];
                        // IF THIS KIND OF STOCK IS NOT IN THE BOOK ANYMORE
                        $this->Book->create();
                        $this->Book->save(array(
                            'profit' => '0',
                            'stock_id' => $delOffer['stock_id'],
                            'user_id' => $delOffer['user_id'],
                            'quantity' => $delOffer['quantity'],
                            'average_price' => $avg
                        ));
                    } else {
                        // ADD UP TO THE EXISTING
                        $this->Book->id = $boo['Book']['id'];
                        $this->Book->saveField('quantity', $boo['Book']['quantity'] + $delOffer['quantity']);
                    }
                }
            }
            $i++;
        }

        $this->Session->setFlash(__($i.' old offers deleted'));
        $this->redirect(array('controller' => 'func', 'action' => 'index'));
	}
	
	//DELETE BOOKS WITH NO USERS
	// TODO
	
	// CREATE NEW SELL OFFERS
	public function admin_create_offers() {
	    $this->loadModel('Offer');
	    
        foreach($this->Func->find('all') as $st){
            $data = array(
                'quantity' => 1000+rand(1,1000),
                'price' => round($st['Func']['value'] - $st['Func']['value']*0.02, 2),
                'type' => 2,
                'user_id' => 2,
                'stock_id' => $st['Func']['id'],
                'stock_name' => $st['Func']['name'],
                'date' => date('Y-m-d H:i:s', time()),
                'bought' => $st['Func']['value']
            );
            $this->Offer->create();
            $this->Offer->save($data);
        }
        $this->Session->setFlash(__('Offers created'));
        $this->redirect(array('controller' => 'func', 'action' => 'index'));
	}
	
	// MESS WITH THE MARKET
	// Change All Stocks Value
	public function admin_change() {
	    foreach($this->Stock->find('all') as $top){
            $rand = $top['Stock']['value'] + (rand(1,100)-50)/100;
            $data = array('id' => $top['Stock']['id'], 'value' => $rand ,
             'variation' => $rand - $top['Stock']['yesterday']);
            $this->Stock->save($data);
        }

        $this->Session->setFlash(__('Stocks changed'));
        $this->redirect(array('controller' => 'func', 'action' => 'index'));
	}
	
	// Set Stock Value to Yesterday's (or the opposite)
	public function admin_reset_stock_value() {
	    $this->Stock->updateAll(
            //array('Stock.yesterday' => 'Stock.value')
            array('Stock.value' => 'Stock.yesterday')
        );
        $this->Session->setFlash(__('Stocks changed'));
        $this->redirect(array('controller' => 'func', 'action' => 'index'));
	}
	
	// CRON JOBS
	
    // EVERY NIGHT at 1:00 am
	public function admin_book_calcul() {
	    $this->layout = 'ajax';
        $this->loadModel('User');
        $req = $this->Book->query("SELECT user_id AS id,SUM(quantity * average_price) AS yesterday_book_value FROM fbgame_books AS Book GROUP BY user_id;");
        
        $data = array();
        foreach($req as $bk){
            $data[]['User'] = $bk[0];
        }
        
        foreach($req as $bk){
            if($pending = $this->User->find('count', array('conditions' => array('User.id' => $bk[0]['id'])))){
                $this->User->id = $bk[0]['id'];
                $this->User->saveField('yesterday_book_value', $bk[0]['yesterday_book_value']);
            }
            $this->User->clear();
        }
	}
	
	// STORE stock value in YearVariation Table
    // EVERY NIGHT at 1:00 am
	public function admin_store() {
	    $this->layout = 'ajax';
        $this->loadModel('YearVariation');
        $arr;
        echo "Starting ...\n";
        $req = $this->Func->find('all', array('recursive' => -1));
        foreach($req as $top){
            $data = array(
                'stock_id' => $top['Func']['id'], 'stock_name' => $top['Func']['name'], 'value' => $top['Func']['value'],
                'date' => date('Y-m-d',strtotime('yesterday'))
            );
            $this->YearVariation->create();
            $this->YearVariation->save($data);

            $data2 = array(
                'id' => $top['Func']['id'], 'yesterday' => ($top['Func']['value'])
            );
            $arr[] = $this->Func->save($data2);
        }
        print_r($arr);
        echo "Done ...\n";
        //$this->Session->setFlash(__('Stocks updated'));
        //$this->redirect(array('controller' => 'stocks', 'action' => 'func'));
    }
    
        
    public function adminGetFriendsList(){
        $app_user = array();
        $app_invited_user = array();
        $app_non_user = array();
        
        // Run fql query
        /*$params = array(
            'method' => 'fql.query',
            'query' => "SELECT recipient_uid FROM apprequest WHERE app_id = ".FacebookInfo::getConfig('appId')." AND recipient_uid IN (SELECT uid2 FROM friend WHERE uid1 = me())",
        );
        $friends_invited = FB::api($params);*/
        // GET INVITED FRIENDS
        /*if(isset($friends_invited)){
            foreach ($friends_invited as $fr){
                $app_invited_user[] = $fr['recipient_uid'];
            }
        }*/
        
        // GET ALL FRIENDS
        // $friends = FB::api('me/friends?fields=installed,name','GET');
        
        $i = 0;
        $go = 1;
        while ($go){
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
                if(count($app_non_user) > 5){
                    $go = 0;
                }
            } else {
                $go = 0;
            }
        }
    }
    
}

?>