<?php
	namespace Krypton;
		define('host', $_CONFIG['mysql']['host']);
		define('user', $_CONFIG['mysql']['user']);
		define('pass', $_CONFIG['mysql']['pass']);
		define('db', $_CONFIG['mysql']['db']);
		
				$Connect = '';
	class MySQL
	{
		
		public function Connect() 
		{	
			return 
			$this->Connect = new \PDO('mysql:host='.host.'; dbname='.db.';charset=utf8', user, pass);
			$this->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
		}
	}

?>