<?php
class LizSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $books = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'stock_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'average_price' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'profit' => array('type' => 'float', 'null' => true, 'default' => '0.00', 'length' => '10,2'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	public $categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'value' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'yesterday_value' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	public $fbrequests = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'request_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'checked' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'touser_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	public $friends = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'friend_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'facebook_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'req_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);
	public $indices = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'stock_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
	public $offers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'price' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'type_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'stock_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	public $stocks = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comment' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2),
		'yesterday' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'value' => array('type' => 'float', 'null' => false, 'default' => '0.01', 'length' => '10,2'),
		'variation' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '5,2'),
		'img' => array('type' => 'string', 'null' => false, 'default' => 'http://www.wildstocks-game.com/img/logo_medium.png', 'length' => 250, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	public $transactions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'buyer_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'seller_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'stock_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'value' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 25, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cash' => array('type' => 'float', 'null' => false, 'default' => '1500.00', 'length' => '10,2'),
		'yesterday_book_value' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '10,2'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 150, 'key' => 'unique', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'role' => array('type' => 'string', 'null' => true, 'default' => 'normal', 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'help_steps' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'facebook_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'stock_number_ach' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'stock_value_ach' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'email' => array('column' => 'email', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
	public $year_variations = array(
		'stock_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'stock_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'value' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,2'),
		'date' => array('type' => 'date', 'null' => false, 'default' => null),
		'indexes' => array(

		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);
}
