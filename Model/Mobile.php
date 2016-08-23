<?php
App::uses('AppModel', 'Model');

class Mobile extends AppModel {
    
    public $useTable = 'stocks';

    // public $name = 'Stock';
      
	public $hasMany = array(
		'Offer' => array(
			'className' => 'Offer',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'Book' => array(
    		'className' => 'Book',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}
