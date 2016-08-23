<?php
App::uses('AppModel', 'Model');

class User extends AppModel {

	public $displayField = 'name';

	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please enter a valid email address'
			),
		 	'isUnique' => array(
				'rule' => 'isUnique',
   				'message' => 'This address already exists'
			)
		),
		'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        )
	);

	public $hasMany = array(
		'Offer' => array(
			'className' => 'Offer',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => array('date' => 'DESC'),
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'Friend' => array(
    		'className' => 'Friend',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
        ),
        'Book' => array(
    		'className' => 'Book',
			'dependent' => false,
		),
		'BuyTransac' => array(
    		'className' => 'Transaction',
			'foreignKey' => 'buyer_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => array('date' => 'DESC'),
			'limit' => '10',
        ),
        'SellTransac' => array(
    		'className' => 'Transaction',
			'foreignKey' => 'seller_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => array('date' => 'DESC'),
			'limit' => '10',
        ),
	);
	public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
	        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	    }
	    return true;
	}
}
