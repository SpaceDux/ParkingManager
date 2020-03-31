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
			$this->booking = new Booking;

			$this->Assign('url', $_CONFIG['site']['url']); //{URL} Site URL
			$this->Assign('tpl', $_CONFIG['site']['template']); //{TPL} Skin Name
			$this->Assign('site_name', $_CONFIG['site']['name']); //{SITE_NAME} Site Name
			$this->Assign('copy', $_CONFIG['misc']['copy']); //{SITE_NAME} Site Name
			if(isset($_SESSION['ID'])) {
				$this->Assign('first_name', $this->user->User_Info("FirstName"));
				$this->Assign('last_name', $this->user->User_Info("LastName"));
				$this->Assign('email', $this->user->User_Info("EmailAddress"));
				$this->Assign('rank', $this->user->User_Info("User_Rank"));
				$this->Assign('telephone', $this->user->User_Info("Telephone"));
				$this->Assign('sites', $this->pm->PM_ListSitesAsSelect());
				$this->Assign('myvehicles', $this->vehicles->Vehicles_DropdownOpts());
				$this->Assign('mybookings', $this->booking->Booking_ListAllBookingsAsHtml());
				$this->Assign('previousbookings', $this->booking->Booking_ListAllPreviousBookingsAsHtml());
			}

			$this->user = null;
			$this->pm = null;
			$this->vehicles = null;
			$this->booking = null;
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
