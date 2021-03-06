<?php
	namespace ParkingManager;

	// Template Engine is based on Fenrir, written by Ryan Williams
	// Repo: https://github.com/CrySys-UK/Fenrir

	class Template
	{
		private $assignedValues = array();
		private $partialBuffer;
		private $tpl;
		//Construct Function (First steps, checks if exists)
		function __construct($_path = '')
		{
			if(!empty($_path))
			{
				if(file_exists($_path))
				{
					ob_start();
					include($_path);
					$this->tpl .= ob_get_clean();
					ob_end_clean();
				}
				else
				{
					echo "Fenrir Template System Error: File not found! PATH = ".$_path;
				}
			}

		}
		//The assigned Parameters {url} etc.
		function SetParams()
		{
			global $_CONFIG;
			$this->user = new User;
			$this->pm = new PM;
			$this->vehicles = new Vehicles;
			$this->account = new Account;
			$this->payment = new Payment;
			$this->external = new External;

			$this->Assign('url', $_CONFIG['site']['url']); //{URL} Site URL
			$this->Assign('tpl', $_CONFIG['site']['template']); //{TPL} Skin Name
			$this->Assign('site_name', $_CONFIG['site']['name']); //{SITE_NAME} Site Name
			$this->Assign('copy', $_CONFIG['misc']['copy']); //{SITE_NAME} Site Name
			$this->Assign('scripts', $this->pm->Scripts());
			$this->Assign('stylesheets', $this->pm->Stylesheets());
			if(isset($_SESSION['id'])) {
				$this->Assign('fname', $this->user->Info("FirstName")); //{FNAME} Active User's first name
				$this->Assign('vehtypes', $this->pm->Vehicle_Types_DropdownOpt()); //{VEHICLE_TYPES} returns the <option>'s
				$this->Assign('sites', $this->pm->Sites_DropdownOpt()); //{VEHICLE_TYPES} returns the <option>'s
				$this->Assign('accounts', $this->account->Account_DropdownOpt()); //{VEHICLE_TYPES} returns the <option>'s
				$this->Assign('list_accounts', $this->account->List_Accounts()); //{ACCOUNTS} returns the full html list of accounts
				$this->Assign('tariff_groups', $this->pm->Tariff_Groups_DowndownOpt());
				$this->Assign('printers', $this->pm->Printers_DropdownOpt());
				$this->Assign('list_sites', $this->pm->List_Sites());
				$this->Assign('list_users', $this->user->List_Users());
				$this->Assign('anpr_count', $this->vehicles->ANPR_Feed_Count());
				$this->Assign('renewal_count', $this->vehicles->Renewal_Feed_Count());
				$this->Assign('all_count', $this->vehicles->Renewal_Feed_Count() + $this->vehicles->ANPR_Feed_Count() + $this->vehicles->Parked_Feed_Count());
				$this->Assign('yardcheck', $this->vehicles->YardCheck());
				$this->Assign('settlement_groups', $this->payment->Settlement_Groups());
				$this->Assign('blacklist_alert', $this->vehicles->ViewBlacklist(1));
				$this->Assign('blacklist_banned', $this->vehicles->ViewBlacklist(2));
				$this->Assign('overstayed', $this->vehicles->GetExpired());
			}
			$this->user = null;
			$this->pm = null;
			$this->vehicles = null;
			$this->account = null;
			$this->payment = null;
			$this->external = null;
		}
		//This function takes the set params and turns them into an actual function
		function Assign($_searchString, $_replaceString)
		{
			if(!empty($_searchString))
			{
				$this->assignedValues[strtoupper($_searchString)] = $_replaceString;
			}
		}
		//Combines everything and echo's the template
		function Show()
		{
			if(count($this->assignedValues) > 0)
			{
				foreach ($this->assignedValues as $key => $value)
				{
					$this->tpl = str_ireplace('{'.$key.'}', $value, $this->tpl);
				}
			}
			echo $this->tpl;
		}
	}

?>
