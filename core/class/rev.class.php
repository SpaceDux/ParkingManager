<?php
	namespace ParkingManager;
	class Rev
	{
		public $dbc;
		//Base Connection with LOCAL database
		public function __construct()
		{
			global $_CONFIG;
			try {
				$this->dbc = new \PDO('mysql:host='.$_CONFIG['ANPR']['Host'].':'.$_CONFIG['ANPR']['Port'].';dbname='.$_CONFIG['ANPR']['DB'].';charset=utf8', $_CONFIG['ANPR']['User'], $_CONFIG['ANPR']['Pass'],array(
    		\PDO::ATTR_PERSISTENT => true
			));
			} catch (\PDOException $e) {
				echo "ParkingManager: MySQL Engine Error ::".$e->getMessage();
				die();
			}
		}
	}

?>
