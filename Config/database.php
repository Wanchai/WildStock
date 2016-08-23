<?php
class DATABASE_CONFIG {

	public $dbconf;

	public $wsdeploy = array(

	);

	public $test = array(

	);

	public $local = array(
		'datasource' => 'Database/Postgres',
		'persistent' => false,
		'host' => '127.0.0.1',
		'port' => '5432',
		'login' => 'postgres',
		'password' => 'test',
		'database' => 'ws',
		'prefix' => 'fbgame_',
	);

	public $cleardb = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'prefix' => 'prod_',
	);

    public $ovh = array(

	);

    public function __construct(){

        if(env('SERVER_NAME') == LOCAL_SERVER){
            // TEST DB
            $this->dbconf = $this->local;
        }else{
            // PROD DB
            // $this->dbconf = $this->wsdeploy;
            $this->dbconf = $this->test;
        }
    }
}