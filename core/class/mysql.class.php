<?php
	namespace ParkingManager;
	class MySQL
	{
		public $dbc;
		//Base Connection with LOCAL database
		public function __construct()
		{
			global $_CONFIG;
			try {
				$this->dbc = new \PDO('mysql:host='.$_CONFIG['mysql']['host'].':'.$_CONFIG['mysql']['port'].';dbname='.$_CONFIG['mysql']['db'].';charset=utf8', $_CONFIG['mysql']['user'], $_CONFIG['mysql']['pass'],array(
    		\PDO::ATTR_PERSISTENT => true
			));
			} catch (\PDOException $e) {
				echo "ParkingManager: MySQL Engine Error ::".$e->getMessage();
				die();
			}
		}
	}

?>
