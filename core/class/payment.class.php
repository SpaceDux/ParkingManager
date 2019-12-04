<?php
	namespace ParkingManager;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

	class Payment
	{
		// Vars
		protected $mysql;

    function PaymentOptions($Plate)
		{
			$this->mysql = new MySQL;
			$this->account = new Account;
			$this->etp = new ETP;
			$accCk = $this->account->Account_Check($Plate);
			$snapCk = $this->etp->Check_SNAP($Plate);
			$html = "";

			if($snapCk !== "ERROR")
			{
				if($accCk == TRUE) {
				$html .= '<nav>
										<div class="nav nav-tabs" id="nav-tab" role="tablist">
											<a class="nav-item nav-link" id="nav-cash-tab" data-toggle="tab" href="#nav-cash" role="tab" aria-controls="nav-cash" aria-selected="true"><i class="fa fa-money-bill-wave"></i> Cash</a>
											<a class="nav-item nav-link" id="nav-card-tab" data-toggle="tab" href="#nav-card" role="tab" aria-controls="nav-card" aria-selected="false"><i class="far fa-credit-card"></i> Card</a>
											<a class="nav-item nav-link active" id="nav-acc-tab" data-toggle="tab" href="#nav-acc" role="tab" aria-controls="nav-acc" aria-selected="false"><i class="fas fa-file-invoice"></i> Account</a>';
										if($snapCk == TRUE) {
				$html .= '		<a class="nav-item nav-link" id="nav-snap-tab" data-toggle="tab" href="#nav-snap" role="tab" aria-controls="nav-snap" aria-selected="false"><i class="fas fa-check-circle" style="color: green;"></i> SNAP</a>';
										} else {
				$html .= '		<a class="nav-item nav-link disabled" id="nav-snap-tab" data-toggle="tab" href="#nav-snap" role="tab" aria-controls="nav-snap" aria-selected="false"><i class="fas fa-times-circle" style="color: red;"></i> SNAP</a>';
										}
				$html .= '
											<a class="nav-item nav-link" id="nav-fuel-tab" data-toggle="tab" href="#nav-fuel" role="tab" aria-controls="nav-fuel" aria-selected="false"><i class="fas fa-gas-pump"></i> Fuel Card</a>
										</div>
									</nav>
									<div class="tab-content" id="nav-tabContent">
										<!-- Cash Tab -->
										<div class="tab-pane fade" id="nav-cash" role="tabpanel" aria-labelledby="nav-cash-tab">
											<label>Choose a Cash Service</label>
											<div id="Cash_Service">

											</div>
										</div>
										<!-- Card Tab  -->
										<div class="tab-pane fade" id="nav-card" role="tabpanel" aria-labelledby="nav-card-tab">
											<label>Choose a Card Service</label>
											<div id="Card_Service">

											</div>
										</div>
										<!-- Account (KingPay) Tab  -->
										<div class="tab-pane fade show active" id="nav-acc" role="tabpanel" aria-labelledby="nav-acc-tab">
											<label>Choose a Account Service</label>
											<div id="Account_Service">

											</div>
										</div>
										<!-- SNAP Tab  -->
										<div class="tab-pane fade" id="nav-snap" role="tabpanel" aria-labelledby="nav-snap-tab">
											<label>Choose a SNAP Service</label>
											<div id="SNAP_Service">

											</div>
										</div>
										<!-- Fuel Tab  -->
										<div class="tab-pane fade" id="nav-fuel" role="tabpanel" aria-labelledby="nav-fuel-tab">
											<label>Choose a Fuel Card Service</label>
											<div id="Fuel_Service">

											</div>
										</div>
									</div>';
				} else if($snapCk == TRUE) {
					$html .= '<nav>
											<div class="nav nav-tabs" id="nav-tab" role="tablist">
												<a class="nav-item nav-link" id="nav-cash-tab" data-toggle="tab" href="#nav-cash" role="tab" aria-controls="nav-cash" aria-selected="true"><i class="fa fa-money-bill-wave"></i> Cash</a>
												<a class="nav-item nav-link" id="nav-card-tab" data-toggle="tab" href="#nav-card" role="tab" aria-controls="nav-card" aria-selected="false"><i class="far fa-credit-card"></i> Card</a>
												<a class="nav-item nav-link" id="nav-acc-tab" data-toggle="tab" href="#nav-acc" role="tab" aria-controls="nav-acc" aria-selected="false"><i class="fas fa-file-invoice"></i> Account</a>';
											if($snapCk == TRUE) {
					$html .= '		<a class="nav-item nav-link active" id="nav-snap-tab" data-toggle="tab" href="#nav-snap" role="tab" aria-controls="nav-snap" aria-selected="false"><i class="fas fa-check-circle" style="color: green;"></i> SNAP</a>';
											} else {
					$html .= '		<a class="nav-item nav-link disabled" id="nav-snap-tab" data-toggle="tab" href="#nav-snap" role="tab" aria-controls="nav-snap" aria-selected="false"><i class="fas fa-times-circle" style="color: red;"></i> SNAP</a>';
											}
					$html .= '
												<a class="nav-item nav-link" id="nav-fuel-tab" data-toggle="tab" href="#nav-fuel" role="tab" aria-controls="nav-fuel" aria-selected="false"><i class="fas fa-gas-pump"></i> Fuel Card</a>
											</div>
										</nav>
										<div class="tab-content" id="nav-tabContent">
											<!-- Cash Tab -->
											<div class="tab-pane fade" id="nav-cash" role="tabpanel" aria-labelledby="nav-cash-tab">
												<label>Choose a Cash Service</label>
												<div id="Cash_Service">

												</div>
											</div>
											<!-- Card Tab  -->
											<div class="tab-pane fade" id="nav-card" role="tabpanel" aria-labelledby="nav-card-tab">
												<label>Choose a Card Service</label>
												<div id="Card_Service">

												</div>
											</div>
											<!-- Account (KingPay) Tab  -->
											<div class="tab-pane fade" id="nav-acc" role="tabpanel" aria-labelledby="nav-acc-tab">
												<label>Choose a Account Service</label>
												<div id="Account_Service">

												</div>
											</div>
											<!-- SNAP Tab  -->
											<div class="tab-pane fade show active" id="nav-snap" role="tabpanel" aria-labelledby="nav-snap-tab">
												<label>Choose a SNAP Service</label>
												<div id="SNAP_Service">

												</div>
											</div>
											<!-- Fuel Tab  -->
											<div class="tab-pane fade" id="nav-fuel" role="tabpanel" aria-labelledby="nav-fuel-tab">
												<label>Choose a Fuel Card Service</label>
												<div id="Fuel_Service">

												</div>
											</div>
										</div>';
				} else {
					$html .= '<nav>
											<div class="nav nav-tabs" id="nav-tab" role="tablist">
												<a class="nav-item nav-link active" id="nav-cash-tab" data-toggle="tab" href="#nav-cash" role="tab" aria-controls="nav-cash" aria-selected="true"><i class="fa fa-money-bill-wave"></i> Cash</a>
												<a class="nav-item nav-link" id="nav-card-tab" data-toggle="tab" href="#nav-card" role="tab" aria-controls="nav-card" aria-selected="false"><i class="far fa-credit-card"></i> Card</a>
												<a class="nav-item nav-link" id="nav-acc-tab" data-toggle="tab" href="#nav-acc" role="tab" aria-controls="nav-acc" aria-selected="false"><i class="fas fa-file-invoice"></i> Account</a>';
											if($snapCk == TRUE) {
					$html .= '		<a class="nav-item nav-link" id="nav-snap-tab" data-toggle="tab" href="#nav-snap" role="tab" aria-controls="nav-snap" aria-selected="false"><i class="fas fa-check-circle" style="color: green;"></i> SNAP</a>';
											} else {
					$html .= '		<a class="nav-item nav-link disabled" id="nav-snap-tab" data-toggle="tab" href="#nav-snap" role="tab" aria-controls="nav-snap" aria-selected="false"><i class="fas fa-times-circle" style="color: red;"></i> SNAP</a>';
											}
					$html .= '
												<a class="nav-item nav-link" id="nav-fuel-tab" data-toggle="tab" href="#nav-fuel" role="tab" aria-controls="nav-fuel" aria-selected="false"><i class="fas fa-gas-pump"></i> Fuel Card</a>
											</div>
										</nav>
										<div class="tab-content" id="nav-tabContent">
											<!-- Cash Tab -->
											<div class="tab-pane fade show active" id="nav-cash" role="tabpanel" aria-labelledby="nav-cash-tab">
												<label>Choose a Cash Service</label>
												<div id="Cash_Service">

												</div>
											</div>
											<!-- Card Tab  -->
											<div class="tab-pane fade" id="nav-card" role="tabpanel" aria-labelledby="nav-card-tab">
												<label>Choose a Card Service</label>
												<div id="Card_Service">

												</div>
											</div>
											<!-- Account (KingPay) Tab  -->
											<div class="tab-pane fade" id="nav-acc" role="tabpanel" aria-labelledby="nav-acc-tab">
												<label>Choose a Account Service</label>
												<div id="Account_Service">

												</div>
											</div>
											<!-- SNAP Tab  -->
											<div class="tab-pane fade" id="nav-snap" role="tabpanel" aria-labelledby="nav-snap-tab">
												<label>Choose a SNAP Service</label>
												<div id="SNAP_Service">

												</div>
											</div>
											<!-- Fuel Tab  -->
											<div class="tab-pane fade" id="nav-fuel" role="tabpanel" aria-labelledby="nav-fuel-tab">
												<label>Choose a Fuel Card Service</label>
												<div id="Fuel_Service">

												</div>
											</div>
										</div>';
				}
			}
			else
			{
				// SNAP CHECK ERROR
				if($accCk == TRUE) {
				$html .= '<nav>
										<div class="nav nav-tabs" id="nav-tab" role="tablist">
											<a class="nav-item nav-link" id="nav-cash-tab" data-toggle="tab" href="#nav-cash" role="tab" aria-controls="nav-cash" aria-selected="true"><i class="fa fa-money-bill-wave"></i> Cash</a>
											<a class="nav-item nav-link" id="nav-card-tab" data-toggle="tab" href="#nav-card" role="tab" aria-controls="nav-card" aria-selected="false"><i class="far fa-credit-card"></i> Card</a>
											<a class="nav-item nav-link active" id="nav-acc-tab" data-toggle="tab" href="#nav-acc" role="tab" aria-controls="nav-acc" aria-selected="false"><i class="fas fa-file-invoice"></i> Account</a>
											<a class="nav-item nav-link disabled" id="nav-snap-tab" data-toggle="tab" href="#nav-snap" role="tab" aria-controls="nav-snap" aria-selected="false"><i class="fas fa-check-circle" style="color: red;"></i> SNAP</a>
											<a class="nav-item nav-link disabled" id="nav-fuel-tab" data-toggle="tab" href="#nav-fuel" role="tab" aria-controls="nav-fuel" aria-selected="false"><i class="fas fa-gas-pump"></i> Fuel Card</a>
										</div>
									</nav>
									<div class="tab-content" id="nav-tabContent">
										<!-- Cash Tab -->
										<div class="tab-pane fade" id="nav-cash" role="tabpanel" aria-labelledby="nav-cash-tab">
											<label>Choose a Cash Service</label>
											<div id="Cash_Service">

											</div>
										</div>
										<!-- Card Tab  -->
										<div class="tab-pane fade" id="nav-card" role="tabpanel" aria-labelledby="nav-card-tab">
											<label>Choose a Card Service</label>
											<div id="Card_Service">

											</div>
										</div>
										<!-- Account (KingPay) Tab  -->
										<div class="tab-pane fade show active" id="nav-acc" role="tabpanel" aria-labelledby="nav-acc-tab">
											<label>Choose a Account Service</label>
											<div id="Account_Service">

											</div>
										</div>
										<!-- SNAP Tab  -->
										<div class="tab-pane fade" id="nav-snap" role="tabpanel" aria-labelledby="nav-snap-tab">
											<label>Choose a SNAP Service</label>
											<div id="SNAP_Service">

											</div>
										</div>
										<!-- Fuel Tab  -->
										<div class="tab-pane fade" id="nav-fuel" role="tabpanel" aria-labelledby="nav-fuel-tab">
											<label>Choose a Fuel Card Service</label>
											<div id="Fuel_Service">

											</div>
										</div>
									</div>';
					} else {
					$html .= '<nav>
											<div class="nav nav-tabs" id="nav-tab" role="tablist">
												<a class="nav-item nav-link active" id="nav-cash-tab" data-toggle="tab" href="#nav-cash" role="tab" aria-controls="nav-cash" aria-selected="true"><i class="fa fa-money-bill-wave"></i> Cash</a>
												<a class="nav-item nav-link" id="nav-card-tab" data-toggle="tab" href="#nav-card" role="tab" aria-controls="nav-card" aria-selected="false"><i class="far fa-credit-card"></i> Card</a>
												<a class="nav-item nav-link" id="nav-acc-tab" data-toggle="tab" href="#nav-acc" role="tab" aria-controls="nav-acc" aria-selected="false"><i class="fas fa-file-invoice"></i> Account</a>
												<a class="nav-item nav-link disabled" id="nav-snap-tab" data-toggle="tab" href="#nav-snap" role="tab" aria-controls="nav-snap" aria-selected="false"><i class="fas fa-check-circle" style="color: red;"></i> SNAP</a>
												<a class="nav-item nav-link disabled" id="nav-fuel-tab" data-toggle="tab" href="#nav-fuel" role="tab" aria-controls="nav-fuel" aria-selected="false"><i class="fas fa-gas-pump"></i> Fuel Card</a>
											</div>
										</nav>
										<div class="tab-content" id="nav-tabContent">
											<!-- Cash Tab -->
											<div class="tab-pane fade show active" id="nav-cash" role="tabpanel" aria-labelledby="nav-cash-tab">
												<label>Choose a Cash Service</label>
												<div id="Cash_Service">

												</div>
											</div>
											<!-- Card Tab  -->
											<div class="tab-pane fade" id="nav-card" role="tabpanel" aria-labelledby="nav-card-tab">
												<label>Choose a Card Service</label>
												<div id="Card_Service">

												</div>
											</div>
											<!-- Account (KingPay) Tab  -->
											<div class="tab-pane fade" id="nav-acc" role="tabpanel" aria-labelledby="nav-acc-tab">
												<label>Choose a Account Service</label>
												<div id="Account_Service">

												</div>
											</div>
											<!-- SNAP Tab  -->
											<div class="tab-pane fade" id="nav-snap" role="tabpanel" aria-labelledby="nav-snap-tab">
												<label>Choose a SNAP Service</label>
												<div id="SNAP_Service">

												</div>
											</div>
											<!-- Fuel Tab  -->
											<div class="tab-pane fade" id="nav-fuel" role="tabpanel" aria-labelledby="nav-fuel-tab">
												<label>Choose a Fuel Card Service</label>
												<div id="Fuel_Service">

												</div>
											</div>
										</div>';
				}
			}

			echo $html;
			$this->mysql = null;
			$this->account = null;
			$this->etp = null;
		}
		// Return all services available for that veh type and expiry
		function PaymentServices_Dropdown($Type, $Expiry, $Plate)
		{
			$this->mysql = new MySQL;
			$this->user = new User;
			$this->pm = new PM;
			$campus = $this->user->Info("Site");

			$Cash = "";
			$Card = "";
			$Account = "";
			$SNAP = "";
			$Fuel = "";

			$stmt = $this->mysql->dbc->prepare("SELECT * FROM tariffs WHERE Site = ? AND Expiry = ? AND Status < 1 AND VehicleType = ? OR Site = ? AND Expiry = 1 AND Status < 1 AND VehicleType = ? ORDER BY Gross ASC");
			$stmt->bindParam(1, $campus);
			$stmt->bindParam(2, $Expiry);
			$stmt->bindParam(3, $Type);
			$stmt->bindParam(4, $campus);
			$stmt->bindParam(5, $Type);

			$stmt->execute();

			$stmt2 = $this->mysql->dbc->prepare("SELECT * FROM tariffs WHERE Site = ? AND Status < 1 AND VehicleType = 0 ORDER BY Gross ASC");
			$stmt2->bindParam(1, $campus);
			$stmt2->execute();

			$Cash .= '<select class="form-control form-control-lg" name="Payment_Service_Cash" id="Payment_Service_Cash">';
			$Card .= '<select class="form-control form-control-lg" name="Payment_Service_Card" id="Payment_Service_Card">';
			$Account .= '<select class="form-control form-control-lg" name="Payment_Service_Account" id="Payment_Service_Account">';
			$SNAP .= '<select class="form-control form-control-lg" name="Payment_Service_SNAP" id="Payment_Service_SNAP">';
			$Fuel .= '<select class="form-control form-control-lg" name="Payment_Service_Fuel" id="Payment_Service_Fuel">';
			foreach ($stmt->fetchAll() as $row) {
				if($row['Cash'] == 1) {
					$Cash .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].' - £'.$row['Gross'].'</option>';
				}

				if($row['Card'] == 1) {
					$Card .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].' - £'.$row['Gross'].'</option>';
				}

				if($row['Account'] == 1) {
					$Account .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].' - £'.$row['Gross'].'</option>';
				}

				if($row['Snap'] == 1) {
					$SNAP .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].' - £'.$row['Gross'].'</option>';
				}

				if($row['Fuel'] == 1) {
					$Fuel .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].' - £'.$row['Gross'].'</option>';
				}
			}
			$Cash .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
			$Card .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
			$Account .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
			$SNAP .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
			$Fuel .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
			foreach ($stmt2->fetchAll() as $row) {
				if($row['Cash'] == 1) {
					$Cash .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].' - £'.$row['Gross'].'</option>';
				}

				if($row['Card'] == 1) {
					$Card .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].' - £'.$row['Gross'].'</option>';
				}

				if($row['Account'] == 1) {
					$Account .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].' - £'.$row['Gross'].'</option>';
				}

				if($row['Snap'] == 1) {
					$SNAP .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].' - £'.$row['Gross'].'</option>';
				}

				if($row['Fuel'] == 1) {
					$Fuel .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].' - £'.$row['Gross'].'</option>';
				}
			}

			$Cash .= '</select>
								<hr>
								<button type="button" style="width: 100%;" data-toggle="modal" data-target="#Payment_ConfirmationCash_Modal" class="btn btn-primary btn-lg">Confirm Cash Transaction</button>';
			$Card .= '</select>
								<hr>
								<button type="button" style="width: 100%;" data-toggle="modal" data-target="#Payment_ConfirmationCard_Modal" class="btn btn-primary btn-lg">Confirm Card Transaction</button>';
			$Account .= '</select>
								<hr>
								<label>Select an account to charge</label>
								<select name="Payment_Account_ID" id="Payment_Account_ID" class="form-control form-control-lg">
								'.$this->pm->Account_DropdownOpt($Plate).'
								<select>
								<hr>
								<button type="button" style="width: 100%;" data-toggle="modal" data-target="#Payment_ConfirmationAcc_Modal" class="btn btn-primary btn-lg">Confirm Account Transaction</button>';
			$SNAP .= '</select>
								<hr>
								<button type="button" style="width: 100%;" data-toggle="modal" data-target="#Payment_ConfirmationSNAP_Modal" class="btn btn-primary btn-lg">Confirm SNAP Transaction</button>';
			$Fuel .= '</select>
								<hr>
								<label>Fuel Card Swipe</label>
								<input type="password" class="form-control form-control-lg" id="FuelCard_Swipe" placeholder="Please swipe the fuel card...">
								<hr>
								<div class="form-row">
	                <div class="col-6">
	                  <label>Fuel Card Number</label>
	                  <input type="text" class="form-control" placeholder="Fuel Card Number" id="Payment_FuelCard_Number">
	                </div>
	                <div class="col-3">
	                  <label>Expiration Date</label>
	                  <input type="text" class="form-control" placeholder="Expiry (02/2020)" id="Payment_FuelCard_Expiry">
									</div>
	                <div class="col-3">
	                  <label>Restriction Code (DKV)</label>
	                  <input type="text" class="form-control" placeholder="RC Number" id="Payment_FuelCard_RC">
									</div>
                </div>
								<small class="form-text text-muted">
								If you\'re using DKV, please ensure the Restriction Code (RC) is 90!, If it\'s left blank or not 90, the transaction will be refused. (DKV ONLY)
								</small>
								<hr>
								<button type="button" style="width: 100%;" data-toggle="modal" data-target="#Payment_ConfirmationFuel_Modal" class="btn btn-primary btn-lg">Confirm Fuel Card Transaction</button>';

			$result = array (
					'Cash' => $Cash,
					'Card' => $Card,
					'Account' => $Account,
					'Snap' => $SNAP,
					'Fuel' => $Fuel
			);

			echo json_encode($result);

			$this->mysql = null;
			$this->user = null;
			$this->pm = null;
		}
		// Add payment into db
		function New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID, $ETP, $Capture_Time, $Expiry, $CardType = '', $CardNo = '', $CardEx = '')
		{
			$this->mysql = new MySQL;
			$this->user = new User;

			$Site = $this->user->Info("Site");
			$Author = $this->user->Info("FirstName");
			$Service_Name = $this->Payment_TariffInfo($Service, "Name");
			$Ticket_Name = $this->Payment_TariffInfo($Service, "TicketName");
			$Service_Settlement_Group = $this->Payment_TariffInfo($Service, "Settlement_Group");
			$Service_Settlement_Multi = $this->Payment_TariffInfo($Service, "Settlement_Multi");
			$Service_Group = $this->Payment_TariffInfo($Service, "Tariff_Group");
			$Service_Gross = $this->Payment_TariffInfo($Service, "Gross");
			$Service_Nett = $this->Payment_TariffInfo($Service, "Nett");
			$Uniqueref = date("YmdHis").mt_rand(1111, 9999);
			$Processed = date("Y-m-d H:i:s");

			$stmt = $this->mysql->dbc->prepare("INSERT INTO transactions (id, Uniqueref, Parkingref, Site, Method, Plate, Name, Service, Service_Name, Service_Ticket_Name, Service_Group, Gross, Nett, Processed_Time, Vehicle_Capture_Time, Vehicle_Expiry_Time, Ticket_Printed, AccountID, ETPID, Deleted, Deleted_Comment, Settlement_Group, Settlement_Multi, Author, FuelCard_Type, FuelCard_No, FuelCard_Ex, Last_Updated)
																					VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', ?, ?, '0', '', ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bindParam(1, $Uniqueref);
			$stmt->bindParam(2, $Ref);
			$stmt->bindParam(3, $Site);
			$stmt->bindParam(4, $Method);
			$stmt->bindParam(5, $Plate);
			$stmt->bindParam(6, $Name);
			$stmt->bindParam(7, $Service);
			$stmt->bindParam(8, $Service_Name);
			$stmt->bindParam(9, $Ticket_Name);
			$stmt->bindParam(10, $Service_Group);
			$stmt->bindParam(11, $Service_Gross);
			$stmt->bindParam(12, $Service_Nett);
			$stmt->bindParam(13, $Processed);
			$stmt->bindParam(14, $Capture_Time);
			$stmt->bindParam(15, $Expiry);
			$stmt->bindParam(16, $Account_ID);
			$stmt->bindParam(17, $ETP);
			$stmt->bindParam(18, $Service_Settlement_Group);
			$stmt->bindParam(19, $Service_Settlement_Multi);
			$stmt->bindParam(20, $Author);
			$stmt->bindParam(21, $CardType);
			$stmt->bindParam(22, $CardNo);
			$stmt->bindParam(23, $CardEx);
			$stmt->bindParam(24, $Processed);
			if($stmt->execute()) {
				return $Uniqueref;
			} else {
				echo "UNSUCCESSFUL Payment";
			}

			$this->mysql = null;
			$this->user = null;
		}
		// Authorise Transaction / Payment
		function Proccess_Transaction($Method, $Type, $Ref, $Plate, $Name = '', $Trl = '', $Time, $VehType, $Service, $Account_ID = '', $FuelCardNo = '', $FuelCardExpiry = '', $FuelCardRC = '')
		{
			$this->vehicles = new Vehicles;
			$this->etp = new ETP;
			$this->pm = new PM;
			$this->user = new User;
			$name = $this->user->Info("FirstName");
			$Service_Expiry = $this->Payment_TariffInfo($Service, "Expiry");
			$Expiry = date("Y-m-d H:i:s", strtotime($Time.' +'.$Service_Expiry.' hours'));

			if($Type == 1) {
				// If $TYPE is 1 (First time record)
				if($Method == 1) {
					// Create Parking Record
					$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
					// Create Payment Record
					$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP = null, $Time, $Expiry, $CardType = null, $FuelCardNo = null, $FuelCardExpiry = null);
					$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
					if($Payment != "UNSUCCESSFUL") {
						echo json_encode(array('Result' => 1, 'Ref' => $Payment));
						$this->pm->POST_Notifications("A Cash Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
					}
				} else if($Method == 2) {
					// Create Parking Record
					$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
					// Create Payment Record
					$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP = null, $Time, $Expiry, $CardType = null, $FuelCardNo = null, $FuelCardExpiry = null);
					$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
					if($Payment != "UNSUCCESSFUL") {
						echo json_encode(array('Result' => 1, 'Ref' => $Payment));
						$this->pm->POST_Notifications("A Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
					}
				} else if($Method == 3) {
					// Create Parking Record
					$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
					// Create Payment Record
					$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID, $ETP = null, $Time, $Expiry, $CardType = null, $FuelCardNo = null, $FuelCardExpiry = null);
					$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
					if($Payment != "UNSUCCESSFUL") {
						echo json_encode(array('Result' => 1, 'Ref' => $Payment));
						$this->pm->POST_Notifications("A KingPay Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
					}
				} else if($Method == 4) {
					$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
					$ETP = $this->etp->Proccess_Transaction_SNAP($ETPID, $Plate, $Name);
					if($ETP['Status'] != FALSE) {
						// Create Parking Record
						$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
						// Create Payment Record
						$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry);
						$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
						if($Payment != "UNSUCCESSFUL") {
							echo json_encode(array('Result' => 1, 'Ref' => $Payment));
							$this->pm->POST_Notifications("A SNAP Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
						}
					} else {
						echo json_encode(array('Result' => 2, 'Msg' => $ETP['Message']));
					}
				} else if($Method == 5) {
					$CardChk = substr($FuelCardNo, "0", "6");
					if ($CardChk == '704310' AND $FuelCardRC == "90") {
						$CardType = 1; // DKV
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A DKV Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '704310' AND $FuelCardRC != "90") {
						echo json_encode(array('Result' => 2, 'Msg' => '<b>ParkingManager</b> has identified that this card is DKV, however the Restriction Code is not 90 and has therefore been refused.'));
					} else if ($CardChk == '707821') {
						$CardType = 2; // Key Fuels
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A KeyFuels Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '789666') {
						$CardType = 2; // Key Fuels
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A KeyFuels Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '706000') {
						$CardType = 3; // UTA
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A UTA Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '700048') {
						$CardType = 4; // MORGAN
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A MorganFuels Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '708284') {
						$CardType = 4; // MORGAN
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A MorganFuels Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '700676') {
						$CardType = 5; // BP
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A BP Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else {
							echo json_encode(array('Result' => 2, 'Msg' => '<b>ParkingManager</b> is unable to identify this card. If this issue persists, please contact Ryan.'));
					}
				}
			} else if($Type == 2) {
				// If $TYPE is 1 (First time record)
				if($Method == 1) {
					$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
					$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP = null, $Time, $Expiry, $CardType = null, $FuelCardNo = null, $FuelCardExpiry = null);
					$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
					$this->vehicles->ExpiryUpdate($Ref, $Expiry);
					if($Payment != "UNSUCCESSFUL") {
						echo json_encode(array('Result' => 1, 'Ref' => $Payment));
						$this->pm->POST_Notifications("A Cash Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');

					}
				} else if($Method == 2) {
					$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
					$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP = null, $Time, $Expiry, $CardType = null, $FuelCardNo = null, $FuelCardExpiry = null);
					$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
					$this->vehicles->ExpiryUpdate($Ref, $Expiry);
					if($Payment != "UNSUCCESSFUL") {
						echo json_encode(array('Result' => 1, 'Ref' => $Payment));
						$this->pm->POST_Notifications("A Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');

					}
				} else if($Method == 3) {
					$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
					$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID, $ETP = null, $Time, $Expiry, $CardType = null, $FuelCardNo = null, $FuelCardExpiry = null);
					$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
					$this->vehicles->ExpiryUpdate($Ref, $Expiry);
					if($Payment != "UNSUCCESSFUL") {
						echo json_encode(array('Result' => 1, 'Ref' => $Payment));
						$this->pm->POST_Notifications("A KingPay Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');

					}
				} else if($Method == 4) {
					$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
					$ETP = $this->etp->Proccess_Transaction_SNAP($ETPID, $Plate, $Name);
					if($ETP['Status'] != FALSE) {
						$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
						// Create Payment Record
						$Payment = $this->New_Transaction($Ref, $Method, $Plate,  $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType = null, $FuelCardNo = null, $FuelCardExpiry = null);
						$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
						$this->vehicles->ExpiryUpdate($Ref, $Expiry);
						if($Payment != "UNSUCCESSFUL") {
							echo json_encode(array('Result' => 1, 'Ref' => $Payment));
							$this->pm->POST_Notifications("A SNAP Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
						}
					} else {
						echo json_encode(array('Result' => 2, 'Msg' => $ETP['Message']));
					}
				} else if($Method == 5) {
					$CardChk = substr($FuelCardNo, "0", "6");
					if ($CardChk == '704310' AND $FuelCardRC == "90") {
						$CardType = 1; // DKV
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A DKV Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => $ETP['Message']));
						}
					} else if ($CardChk == '704310' AND $FuelCardRC != "90") {
						echo json_encode(array('Result' => 2, 'Msg' => '<b>ParkingManager</b> has identified that this card is DKV, however the Restriction Code is not 90 and has therefore been refused.'));
					} else if ($CardChk == '707821') {
						$CardType = 2; // Key Fuels
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A KeyFuels Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => $ETP['Message']));
						}
					} else if ($CardChk == '789666') {
						$CardType = 2; // Key Fuels
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A KeyFuels Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => $ETP['Message']));
						}
					} else if ($CardChk == '706000') {
						$CardType = 3; // UTA
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A UTA Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => $ETP['Message']));
						}
					} else if ($CardChk == '700048') {
						$CardType = 4; // MORGAN
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A MorganFuels Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => $ETP['Message']));
						}
					} else if ($CardChk == '708284') {
						$CardType = 4; // MORGAN
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A MorganFuels Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => $ETP['Message']));
						}
					} else if ($CardChk == '700676') {
						$CardType = 5; // BP
						$ETPID = $this->Payment_TariffInfo($Service, "ETPID");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP['Status'] != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP['TID'], $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A BP Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							} else {
								echo json_encode(array('Result' => 2, 'Msg' => 'Transaction could not be posted by ParkingManager, please try again.'));
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => $ETP['Message']));
						}
					} else {
							echo json_encode(array('Result' => 2, 'Msg' => '<b>ParkingManager</b> is unable to identify this card. If this issue persists, please contact Ryan.'));
					}
				}
			}


			$this->vehicles = null;
			$this->etp = null;
			$this->pm = null;
			$this->user = null;
		}
		//Payment Service Info
		function Payment_TariffInfo($key, $what)
		{
		 $this->mysql = new MySQL;

		 $stmt = $this->mysql->dbc->prepare("SELECT * FROM tariffs WHERE Uniqueref = ?");
		 $stmt->bindParam(1, $key);
		 $stmt->execute();
		 $result = $stmt->fetch(\PDO::FETCH_ASSOC);
		 return $result[$what];

		 $this->mysql = null;
		}
		//Break Up Fuel Card str
		//String Preperation
		public function Fuel_String_Prepare($string, $start, $end)
		{
			$string = ' ' . $string;
			$ini = strpos($string, $start);
			if ($ini == 0) return '';
			$ini += strlen($start);
			$len = strpos($string, $end, $ini) - $ini;
			return substr($string, $ini, $len);
		}
		function Payment_FC_Break($string)
		{
			$this->pm = new PM;

			$Card = $this->Fuel_String_Prepare($string, ";", "=");
			$expiry = $this->Fuel_String_Prepare($string, "=", "?");
			$expiry_yr = substr($expiry, "0", "2");
			$expiry_m = substr($expiry, "2", "2");
			$rc = substr($expiry, "6", "2");
			$expiry = $expiry_m."/20".$expiry_yr;

			$Card = $this->pm->RemoveSlashes($Card);

			$result = [
				'cardno' => $Card,
				'expiry' => $expiry,
				'rc' => $rc
			];

			echo json_encode($result);

			$this->pm = null;
		}
		// List all payments attached to vehicle
		function PerVehPayments($ref)
		{
			$this->mysql = new MySQL;
			$stmt = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Parkingref = ? AND Deleted < 1 ORDER BY Processed_Time DESC");
			$stmt->bindParam(1, $ref);
			$stmt->execute();
			$result = $stmt->fetchAll();

			$html = '<table class="table table-dark">
	                <thead>
	                  <tr>
	                    <th scope="col">Service</th>
	                    <th scope="col">Method</th>
	                    <th scope="col">Processed</th>
	                    <th scope="col">Printed</th>
	                    <th scope="col">Author</th>
	                    <th scope="col">
												<div class="btn-group float-right" role="group">
													<button type="button" class="btn btn-sm btn-danger" id="PaymentOnUpdate"><i class="fa fa-pound-sign"></i> New Payment</button>
												  <button type="button" class="btn btn-sm btn-danger" id="RefreshUpdatePayments"><i class="fa fa-sync"></i></button>
												</div>
											</th>
	                  </tr>
	                </thead>
                <tbody>';
			foreach($result as $row) {
				$ref = '\''.$row['Uniqueref'].'\'';
				if($row['Method'] == "1") {
					$Method = "Cash";
				} else if($row['Method'] == "2") {
					$Method = "Card";
				} else if($row['Method'] == "3") {
					$Method = "Account";
				} else if($row['Method'] == "4") {
					$Method = "SNAP";
				} else if($row['Method'] == "5") {
					$Method = "Fuel Card";
				}
				$html .= '
				<tr id="Payment_Delete_'.$row['Uniqueref'].'">
					<td>'.$row['Service_Name'].'</td>
					<td>'.$Method.'</td>
					<td>'.date("d/m/y H:i", strtotime($row['Processed_Time'])).'</td>
					<td>'.$row['Ticket_Printed'].'</td>
					<td>'.$row['Author'].'</td>
					<td>
						<div class="btn-group float-right" role="group" aria-label="Options">
							<button type="button" class="btn btn-danger" onClick="Print_Ticket('.$ref.')"><i class="fa fa-print"></i></button>
							<button type="button" class="btn btn-danger" onClick="Payment_Update('.$ref.')"><i class="fa fa-cog"></i></button>
							<button type="button" class="btn btn-danger" onClick="DeleteTransaction('.$ref.')"><i class="fa fa-trash"></i></button>
						</div>
					</td>
				<tr>';
			}
			$html .= '</tbody>
			        </table>';

			echo $html;

			$this->mysql = null;
		}
		// Print Ticket
		function PrintTicket($Ref)
		{
			$this->mysql = new MySQL;
			$this->ticket = new Ticket;
			$this->vehicles = new Vehicles;

			$stmt = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Uniqueref = ?");
			$stmt->bindParam(1, $Ref);
			$stmt->execute();
			$result = $stmt->fetch(\PDO::FETCH_ASSOC);
			$TicketName = $result['Service_Ticket_Name'];
			$Gross = $result['Gross'];
			$Nett = $result['Nett'];
			$Plate = $result['Plate'];
			$Name = $result['Name'];
			$Date = $result['Vehicle_Capture_Time'];
			$Expiry = $result['Vehicle_Expiry_Time'];
			$Method = $result['Method'];
			$Service = $result['Service'];
			if($Method == '1') {
				$Type = "Cash";
			} else if($Method == '2') {
				$Type = "Card";
			} else if($Method == '3') {
				$Type = "Account";
			} else if($Method == '4') {
				$Type = "SNAP";
			} else if($Method == '5') {
				$Type = "Fuel Card";
			}
			$MealCount = $this->Payment_TariffInfo($Service, "Meal_Vouchers");
			$ShowerCount = $this->Payment_TariffInfo($Service, "Shower_Vouchers");
			$Group = $result['Service_Group'];
			$PRef = $result['Parkingref']; // Parking Ref not Payment $Ref is payment
			$ExitKey = $this->vehicles->Info($PRef, "ExitKey");
			$DiscCount = $this->Payment_TariffInfo($Service, "Discount_Vouchers");
			$WifiCount = $this->Payment_TariffInfo($Service, "Wifi_Vouchers");
			$Account_ID = $result['AccountID'];
			$Printed = $result['Ticket_Printed'];
			$ProcessedTime = $result['Processed_Time'];

			$Printed = $Printed + 1;

			$this->ticket->Direction($TicketName, $Gross, $Nett, $Name = '', $Plate, $Ref, $Date, $Expiry, $Type, $MealCount, $ShowerCount, $Group, $ExitKey, $DiscCount, $WifiCount, $Account_ID, $Printed, $ProcessedTime);

			$stmt2 = $this->mysql->dbc->prepare("UPDATE transactions SET Ticket_Printed = ? WHERE Uniqueref = ?");
			$stmt2->bindParam(1, $Printed);
			$stmt2->bindParam(2, $Ref);
			$stmt2->execute();

			$this->mysql = null;
			$this->ticket = null;
			$this->vehicles = null;
		}
		// Transaction History
		function Transaction_List($Start, $End, $Cash, $Card, $Account, $Snap, $Fuel, $Group, $SettlementGroup)
		{
			$this->mysql = new MySQL;
			$this->user = new User;
			$this->account = new Account;

			$Start = date("Y-m-d 00:00:00", strtotime($Start));
			$End = date("Y-m-d 23:59:59", strtotime($End));
			$column = array('Name', 'Plate', 'Service_Name', 'Gross', 'Nett', 'Method', 'Processed_Time', 'AccountID', 'Author');
			$Site = $this->user->Info("Site");


			if($Cash == 1) {
				$IsCash = "1,";
			} else {
				$IsCash = "";
			}
			if($Card == 1) {
				$IsCard = "2,";
			} else {
				$IsCard = "";
			}
			if($Account == 1) {
				$IsAccount = "3,";
			} else {
				$IsAccount = "";
			}
			if($Snap == 1) {
				$IsSnap = "4,";
			} else {
				$IsSnap = "";
			}
			if($Fuel == 1) {
				$IsFuel = "5,";
			} else {
				$IsFuel = "";
			}

			$Methods = $IsCash.$IsCard.$IsAccount.$IsSnap.$IsFuel;
			$Methods = substr_replace($Methods, "", -1);

			$query = 'SELECT * FROM transactions ';


				if(isset($Start) && isset($End) && $Start != '' && $End != '')
				{
					if($Group != "unselected") {
						$query .= 'WHERE Site = '.$Site.' AND Method IN ('.$Methods.') AND Service_Group = '.$Group.' AND Processed_Time BETWEEN ? AND ? ';
					} else if ($SettlementGroup != "unselected") {
						$query .= 'WHERE Site = '.$Site.' AND Method IN ('.$Methods.') AND Settlement_Group = '.$SettlementGroup.' AND Processed_Time BETWEEN ? AND ? ';
					} else {
						$query .= 'WHERE Site = '.$Site.' AND Method IN ('.$Methods.') AND Processed_Time BETWEEN ? AND ? ';
					}
				}
				if(isset($_POST['order']))
				{
				 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
				}
				else
				{
				 $query .= 'ORDER BY Processed_Time DESC ';
				}

				$query1 = '';

				if($_POST["length"] != -1)
				{
				 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
				}

				// die($query.$query1);
			$data = array();

			$stmt = $this->mysql->dbc->prepare($query);
			$stmt->bindParam(1, $Start);
			$stmt->bindParam(2, $End);
			$stmt->execute();
			$count_filter = $stmt->rowCount();

			$stmt2 = $this->mysql->dbc->prepare($query.$query1);
			$stmt2->bindParam(1, $Start);
			$stmt2->bindParam(2, $End);
			$stmt2->execute();
			$count_total = $stmt2->rowCount();

			$data = array();


			foreach($stmt2->fetchAll() as $row) {
				$ref = '\''.$row['Uniqueref'].'\'';

				$options = '<div class="btn-group float-right" role="group" aria-label="Options">
											<button type="button" class="btn btn-danger" onClick="Print_Ticket('.$ref.')"><i class="fa fa-print"></i></button>
											<button type="button" class="btn btn-danger" onClick="DeleteTransaction('.$ref.')"><i class="fa fa-trash"></i></button>
										</div>';
				if($row['Method'] == 1) {
					$Method = "Cash";
				} else if($row['Method'] == 2) {
					$Method = "Card";
				} else if($row['Method'] == 3) {
					$Method = "Account";
				} else if($row['Method'] == 4) {
					$Method = "SNAP";
				} else if($row['Method'] == 5) {
					$Method = "Fuel Card";
				}
				$sub_array = array();
				$sub_array[] = $row['Name'];
				$sub_array[] = $row['Plate'];
				$sub_array[] = $row['Service_Name'];
				$sub_array[] = '£'.$row['Gross'];
				$sub_array[] = '£'.$row['Nett'];
				$sub_array[] = $Method;
				$sub_array[] = date("d/m/y H:i:s", strtotime($row['Processed_Time']));
				$sub_array[] = $this->account->Account_GetInfo($row['AccountID'], "Name");
				$sub_array[] = $row['Author'];
				$sub_array[] = $options;
				if($row['Deleted'] == 1) {
          $sub_array[] = "Deleted";
        } else {
          $sub_array[] = "Active";
        }
				$data[] = $sub_array;
			}
			$output = array("data" =>  $data,
											"recordsFiltered" => $count_filter,
											"recordsTotal" => $count_total);

			echo json_encode($output);

			$this->mysql = null;
			$this->user = null;
			$this->account = null;
		}
		// Delete Payments
		function Payment_Delete($ref)
		{
			$this->mysql = new MySQL;
			$this->etp = new ETP;
			$this->vehicles = new Vehicles;
			$this->pm = new PM;

			$stmt1 = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Uniqueref = ?");
			$stmt1->bindParam(1, $ref);
			$stmt1->execute();
			$record = $stmt1->fetch(\PDO::FETCH_ASSOC);
			$serviceEx = $this->Payment_TariffInfo($record['Service'], "Expiry");
			$parkingref = $record['Parkingref'];
			$expiry = $this->vehicles->Info($parkingref, "Expiry");
			$anpr = $this->vehicles->Info($parkingref, "ANPRRef");
			$new_Expiry = date('Y-m-d H:i:s', strtotime($expiry.' - '.$serviceEx.' hours'));
			$date = date("Y-m-d H:i:s");

			if($record['Method'] > 3) {
				$etpid = $record['ETPID'];
				$delSnap = $this->etp->DeleteTransaction($etpid);
				if($delSnap == TRUE) {
					$stmt = $this->mysql->dbc->prepare("UPDATE transactions SET Deleted = 1, Last_Updated = ? WHERE Uniqueref = ?");
					$stmt->bindParam(1, $date);
					$stmt->bindParam(2, $ref);
					$stmt->execute();
					$this->vehicles->ExpiryUpdate($parkingref, $new_Expiry);
					$this->vehicles->ANPR_PaymentUpdate($anpr, $new_Expiry);
					echo $stmt->rowCount();
					$this->pm->POST_Notifications("A ETP Payment has successfully been deleted, Ref: ".$ref, '0');
				} else {
					echo "0";
				}
			} else {
				$stmt = $this->mysql->dbc->prepare("UPDATE transactions SET Deleted = 1, Last_Updated = ? WHERE Uniqueref = ?");
				$stmt->bindParam(1, $date);
				$stmt->bindParam(2, $ref);
				$stmt->execute();
				$this->vehicles->ExpiryUpdate($parkingref, $new_Expiry);
				$this->vehicles->ANPR_PaymentUpdate($anpr, $new_Expiry);
				echo $stmt->rowCount();
				$this->pm->POST_Notifications("A Payment has successfully been deleted, Ref: ".$ref, '0');
			}


			$this->mysql = null;
			$this->etp = null;
			$this->vehicles = null;
			$this->pm = null;
		}
		function List_Tariffs($Site)
		{
			$this->mysql = new MySQL;
			$html = '
							<div class="Box">
							<table class="table table-bordered table-hover">
							  <thead class="thead-dark">
							    <tr>
							      <th scope="col">Name</th>
							      <th scope="col">Gross</th>
							      <th scope="col">Nett</th>
							      <th scope="col">Shower Vouchers</th>
							      <th scope="col">Meal Vouchers</th>
							      <th scope="col">Discount Vouchers</th>
							      <th scope="col">WiFi Vouchers</th>
							      <th scope="col">Cash</th>
							      <th scope="col">Card</th>
							      <th scope="col">Account</th>
							      <th scope="col">Snap</th>
							      <th scope="col">Fuel</th>
							      <th scope="col">ETP ID</th>
							      <th scope="col">Settlement Group</th>
							      <th scope="col">Status</th>
							      <th scope="col"><i class="fa fa-cog"></i></th>
							    </tr>
							  </thead>
							  <tbody>';

								$html .= '<tr class="table-primary">
														<td colspan="22">ALL VEHICLES</td>
													</tr>';
			$stmt3 = $this->mysql->dbc->prepare("SELECT * FROM tariffs WHERE Site = ? AND Status < 2 AND VehicleType = 0 ORDER BY Expiry, Gross ASC");
			$stmt3->bindParam(1, $Site);
			$stmt3->execute();
			foreach($stmt3->fetchAll() as $row) {
				$ref = '\''.$row['Uniqueref'].'\'';
				$html .= '<tr class="">';
				$html .= '<td>'.$row['Name'].'</td>';
				$html .= '<td>£'.$row['Gross'].'</td>';
				$html .= '<td>£'.$row['Nett'].'</td>';
				$html .= '<td>'.$row['Shower_Vouchers'].'</td>';
				$html .= '<td>'.$row['Meal_Vouchers'].'</td>';
				$html .= '<td>'.$row['Discount_Vouchers'].'</td>';
				$html .= '<td>'.$row['Wifi_Vouchers'].'</td>';
				if($row['Cash'] == 1) {
					$html .= '<td class="table-success">Enabled</td>';
				} else {
					$html .= '<td class="table-danger">Disabled</td>';
				}
				if($row['Card'] == 1) {
					$html .= '<td class="table-success">Enabled</td>';
				} else {
					$html .= '<td class="table-danger">Disabled</td>';
				}
				if($row['Account'] == 1) {
					$html .= '<td class="table-success">Enabled</td>';
				} else {
					$html .= '<td class="table-danger">Disabled</td>';
				}
				if($row['Snap'] == 1) {
					$html .= '<td class="table-success">Enabled</td>';
				} else {
					$html .= '<td class="table-danger">Disabled</td>';
				}
				if($row['Fuel'] == 1) {
					$html .= '<td class="table-success">Enabled</td>';
				} else {
					$html .= '<td class="table-danger">Disabled</td>';
				}
				$html .= '<td>'.$row['ETPID'].'</td>';
				$html .= '<td>'.$row['Settlement_Group'].'</td>';
				if($row['Status'] == 0) {
					$html .= '<td class="table-success">Active</td>';
				} else if($row['Status'] == 1) {
					$html .= '<td class="table-warning">Disabled</td>';
				}
				$html .= '<td>
										<button onClick="Update_Tariff_Tgl('.$ref.')" class="btn btn-primary"><i class="fa fa-cog"></i></button>
									</td>';
			}

			$stmt2 = $this->mysql->dbc->prepare("SELECT * FROM vehicle_types ORDER BY id ASC");
			$stmt2->execute();

			foreach ($stmt2->fetchAll() as $row) {
				$id = $row['id'];
				$html .= '<tr class="table-primary">';
				$html .= '<td colspan="22">'.$row['Name'].'</td>';
				$html .= '<tr>';
				$stmt = $this->mysql->dbc->prepare("SELECT * FROM tariffs WHERE Site = ? AND Status < 2 AND VehicleType = ? ORDER BY Expiry, Gross ASC");
				$stmt->bindParam(1, $Site);
				$stmt->bindParam(2, $id);
				$stmt->execute();
				foreach($stmt->fetchAll() as $row) {
					$ref = '\''.$row['Uniqueref'].'\'';
					$html .= '<tr class="">';
					$html .= '<td>'.$row['Name'].'</td>';
					$html .= '<td>£'.$row['Gross'].'</td>';
					$html .= '<td>£'.$row['Nett'].'</td>';
					$html .= '<td>'.$row['Shower_Vouchers'].'</td>';
					$html .= '<td>'.$row['Meal_Vouchers'].'</td>';
					$html .= '<td>'.$row['Discount_Vouchers'].'</td>';
					$html .= '<td>'.$row['Wifi_Vouchers'].'</td>';
					if($row['Cash'] == 1) {
						$html .= '<td class="table-success">Enabled</td>';
					} else {
						$html .= '<td class="table-danger">Disabled</td>';
					}
					if($row['Card'] == 1) {
						$html .= '<td class="table-success">Enabled</td>';
					} else {
						$html .= '<td class="table-danger">Disabled</td>';
					}
					if($row['Account'] == 1) {
						$html .= '<td class="table-success">Enabled</td>';
					} else {
						$html .= '<td class="table-danger">Disabled</td>';
					}
					if($row['Snap'] == 1) {
						$html .= '<td class="table-success">Enabled</td>';
					} else {
						$html .= '<td class="table-danger">Disabled</td>';
					}
					if($row['Fuel'] == 1) {
						$html .= '<td class="table-success">Enabled</td>';
					} else {
						$html .= '<td class="table-danger">Disabled</td>';
					}
					$html .= '<td>'.$row['ETPID'].'</td>';
					$html .= '<td>'.$row['Settlement_Group'].'</td>';
					if($row['Status'] == 0) {
						$html .= '<td class="table-success">Active</td>';
					} else if($row['Status'] == 1) {
						$html .= '<td class="table-warning">Disabled</td>';
					}
					$html .= '<td>
											<button onClick="Update_Tariff_Tgl('.$ref.')" class="btn btn-primary"><i class="fa fa-cog"></i></button>
										</td>';
				}
			}

			$html .= '</tbody></table></div>';
			echo $html;

			$this->mysql = null;
		}
		// Settlemet Groups dropdown
		function Settlement_DropdownOpt($Site)
		{
			$this->mysql = new MySQL;

			$stmt = $this->mysql->dbc->prepare("SELECT * FROM settlement_groups WHERE Site = ? ORDER BY Set_Order ASC");
			$stmt->bindParam(1, $Site);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$html = "";
			$html .= '<option value="0">-- No Group --</option>';
			foreach($result as $row) {
				$html .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].'</option>';
			}

			echo $html;

			$this->mysql = null;
		}
		function Settlement_Groups()
		{
			$this->mysql = new MySQL;
			$this->user = new User;
			$Site = $this->user->Info("Site");

			$stmt = $this->mysql->dbc->prepare("SELECT * FROM settlement_groups WHERE Site = ? ORDER BY Set_Order ASC");
			$stmt->bindParam(1, $Site);
			$stmt->execute();
			$result = $stmt->fetchAll();
			$html = "";
			$html .= '<option value="unselected">-- Settlement Group --</option>';
			foreach($result as $row) {
				$html .= '<option value="'.$row['Uniqueref'].'">'.$row['Name'].'</option>';
			}

			return $html;

			$this->mysql = null;
			$this->user = null;
		}
		// add a new tariff to pm
		function New_Tariff($Name, $TicketName, $Gross, $Nett, $Expiry, $Group, $Cash, $Card, $Account, $SNAP, $Fuel, $ETPID, $Meal, $Shower, $Discount, $WiFi, $VehType, $Site, $Status, $SettlementGroup, $SettlementMulti)
		{
			$this->mysql = new MySQL;

			$Uniqueref = date("YmdHis").mt_rand(1111, 9999);
			$Time = date("Y-m-d H:i:s");


			$stmt = $this->mysql->dbc->prepare("INSERT INTO tariffs VALUES('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bindParam(1, $Uniqueref);
			$stmt->bindParam(2, $Site);
			$stmt->bindParam(3, $Name);
			$stmt->bindParam(4, $TicketName);
			$stmt->bindParam(5, $Gross);
			$stmt->bindParam(6, $Nett);
			$stmt->bindParam(7, $Expiry);
			$stmt->bindParam(8, $Group);
			$stmt->bindParam(9, $VehType);
			$stmt->bindParam(10, $Shower);
			$stmt->bindParam(11, $Meal);
			$stmt->bindParam(12, $Discount);
			$stmt->bindParam(13, $WiFi);
			$stmt->bindParam(14, $Cash);
			$stmt->bindParam(15, $Card);
			$stmt->bindParam(16, $Account);
			$stmt->bindParam(17, $SNAP);
			$stmt->bindParam(18, $Fuel);
			$stmt->bindParam(19, $ETPID);
			$stmt->bindParam(20, $SettlementGroup);
			$stmt->bindParam(21, $SettlementMulti);
			$stmt->bindParam(22, $Status);
			$stmt->bindParam(23, $Time);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				$result = array('Result' => '1', 'Message' => 'New Tariff has successfully been added into ParkingManager.');
			} else {
				$result = array('Result' => '0', 'Message' => 'New Tariff has NOT been added into ParkingManager. Please try again.');
			}
			echo json_encode($result);

			unset($Uniqueref);

			$this->mysql = null;
		}
		// Update existing Tariff
		// Get and Return Tariff data
		function Update_Tariff_GET($Ref)
		{
			$this->mysql = new MySQL;

			$stmt = $this->mysql->dbc->prepare("SELECT * FROM tariffs WHERE Uniqueref = ?");
			$stmt->bindParam(1, $Ref);
			$stmt->execute();

			echo json_encode($stmt->fetch(\PDO::FETCH_ASSOC));

			$this->mysql = null;
		}
		function Update_Tariff($Ref, $Name, $TicketName, $Gross, $Nett, $Expiry, $Group, $Cash, $Card, $Account, $SNAP, $Fuel, $ETPID, $Meal, $Shower, $Discount, $WiFi, $VehType, $Site, $Status, $SettlementGroup, $SettlementMulti)
		{
			$this->mysql = new MySQL;

			$Time = date("Y-m-d H:i:s");
			$stmt = $this->mysql->dbc->prepare("UPDATE tariffs SET Name = ?, TicketName = ?, Gross = ?, Nett = ?, Expiry = ?, Tariff_Group = ?, Cash = ?, Card = ?, Account = ?, Snap = ?, Fuel = ?, ETPID = ?, Meal_Vouchers = ?, Shower_Vouchers = ?, Discount_Vouchers = ?, Wifi_Vouchers = ?, VehicleType = ?, Site = ?, Status = ?, Settlement_Group = ?, Settlement_Multi = ?, Last_Updated = ? WHERE Uniqueref = ?");
			$stmt->bindParam(1, $Name);
			$stmt->bindParam(2, $TicketName);
			$stmt->bindParam(3, $Gross);
			$stmt->bindParam(4, $Nett);
			$stmt->bindParam(5, $Expiry);
			$stmt->bindParam(6, $Group);
			$stmt->bindParam(7, $Cash);
			$stmt->bindParam(8, $Card);
			$stmt->bindParam(9, $Account);
			$stmt->bindParam(10, $SNAP);
			$stmt->bindParam(11, $Fuel);
			$stmt->bindParam(12, $ETPID);
			$stmt->bindParam(13, $Meal);
			$stmt->bindParam(14, $Shower);
			$stmt->bindParam(15, $Discount);
			$stmt->bindParam(16, $WiFi);
			$stmt->bindParam(17, $VehType);
			$stmt->bindParam(18, $Site);
			$stmt->bindParam(19, $Status);
			$stmt->bindParam(20, $SettlementGroup);
			$stmt->bindParam(21, $SettlementMulti);
			$stmt->bindParam(22, $Time);
			$stmt->bindParam(23, $Ref);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				$result = array('Result' => '1', 'Message' => 'Tariff has successfully been updated in ParkingManager.');
			} else {
				$result = array('Result' => '0', 'Message' => 'Tariff has NOT been updated in ParkingManager. Please try again.');
			}
			echo json_encode($result);

			$this->mysql = null;
		}
		// Search Payment Records VIA Modal
		function Search_Payment_Records($key)
		{
			$string = "%".$key."%";
			$this->mysql = new MySQL;
			$this->user = new User;
			$this->vehicles = new Vehicles;

			$stmt = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Plate LIKE ? OR Name LIKE ? OR Uniqueref = ? OR ETPID = ? ORDER BY Processed_Time DESC LIMIT 20");
			$stmt->bindParam(1, $string);
			$stmt->bindParam(2, $string);
			$stmt->bindParam(3, $key);
			$stmt->bindParam(4, $key);
			$stmt->execute();
			$html = '<table class="table table-dark">
								<thead>
									<tr>
										<th scope="col" style="width: 20%;">Name</th>
										<th scope="col">Plate</th>
										<th scope="col">Processed</th>
										<th scope="col" style="text-align: right"><i class="fa fa-cogs"></i></th>
									</tr>
								</thead>
								<tbody>';

			foreach($stmt->fetchAll() as $row) {
				$timein = '\''.$this->vehicles->Info($row['Parkingref'], "Arrival").'\'';
				$ref = '\''.$row['Parkingref'].'\'';
				$html .= '<tr>';
				$html .= '<td>'.$row['Name'].'</td>';
				$html .= '<td>'.$row['Plate'].'</td>';
				$html .= '<td>'.date("d/m/y H:i", strtotime($row['Processed_Time'])).'</td>';
				$html .= '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Search_Records_Modal" onClick="UpdateVehPaneToggle('.$ref.', '.$timein.')"><i class="fa fa-cog"></i></button></td>';
			}

			$html .= '</tbody>
							</table>';

			echo json_encode($html);

			$this->mysql = null;
			$this->user = null;
			$this->vehicles = null;
		}
		// Download as Excel
		function Download_Sales($Start, $End, $Cash, $Card, $Account, $Snap, $Fuel, $Group)
		{
			$this->mysql = new MySQL;
			$this->user = new User;
			$this->account = new Account;

			$Start = date("Y-m-d 00:00:00", strtotime($Start));
			$End = date("Y-m-d 23:59:59", strtotime($End));

			$Site = $this->user->Info("Site");

			if($Cash == 1) {
				$IsCash = "1,";
			} else {
				$IsCash = "";
			}
			if($Card == 1) {
				$IsCard = "2,";
			} else {
				$IsCard = "";
			}
			if($Account == 1) {
				$IsAccount = "3,";
			} else {
				$IsAccount = "";
			}
			if($Snap == 1) {
				$IsSnap = "4,";
			} else {
				$IsSnap = "";
			}
			if($Fuel == 1) {
				$IsFuel = "5,";
			} else {
				$IsFuel = "";
			}

			$Methods = $IsCash.$IsCard.$IsAccount.$IsSnap.$IsFuel;
			$Methods = substr_replace($Methods, "", -1);

			$totalNett = 0;
			$totalGross = 0;

			if($Group != "unselected") {
				$query = 'SELECT * FROM transactions WHERE Site = '.$Site.' AND Method IN ('.$Methods.') AND Service_Group = '.$Group.' AND Deleted < 1 AND Processed_Time BETWEEN ? AND ? ORDER BY Processed_Time ASC';
			} else {
				$query = 'SELECT * FROM transactions WHERE Site = '.$Site.' AND Method IN ('.$Methods.') AND Deleted < 1 AND Processed_Time BETWEEN ? AND ? ORDER BY Processed_Time ASC';
			}
			$stmt = $this->mysql->dbc->prepare($query);
			$stmt->bindParam(1, $Start);
			$stmt->bindParam(2, $End);
			$stmt->execute();

			$file_name = "Sales Report";

			$spreadsheet = new Spreadsheet();
			//Spreadsheet information
			$spreadsheet->getProperties()
				->setCreator("ParkingManager")
				->setLastModifiedBy("ParkingManager")
				->setTitle("ParkingManager Sales Report")
				->setSubject("Sales History")
				->setDescription("Sales History")
				->setKeywords("parking manager 4 2019 account reports")
				->setCategory("Accounting");
			//header information.
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$file_name.'.xlsx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			$rows = 3;
			$sheet = $spreadsheet->getActiveSheet();
			$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25);
			$styleArray = [
					'font' => [
							'bold' => true,
					],
					'alignment' => [
							'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					],
					'borders' => [
							'top' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
					],
					'fill' => [
							'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
							'rotation' => 90,
							'startColor' => [
									'argb' => 'c41f45',
							],
							'endColor' => [
									'argb' => '9b1837',
							],
					],
			];
			$spreadsheet->getActiveSheet()->getStyle('A'.$rows.':H'.$rows)->applyFromArray($styleArray);
			$spreadsheet->getActiveSheet()->getStyle('A'.$rows.':H'.$rows)->getFont()->getColor()->setARGB('FFFFFF');
			$sheet->setCellValue('A'.$rows, 'Name');
			$sheet->setCellValue('B'.$rows, 'Registration');
			$sheet->setCellValue('C'.$rows, 'Service');
			$sheet->setCellValue('D'.$rows, 'Gross');
			$sheet->setCellValue('E'.$rows, 'Nett');
			$sheet->setCellValue('F'.$rows, 'Method');
			$sheet->setCellValue('G'.$rows, 'Processed');
			$sheet->setCellValue('H'.$rows, 'Account');
			$rows++;
			foreach($stmt->fetchAll() as $data)
			{
				$totalNett += $data['Nett'];
				$totalGross += $data['Gross'];

				if($data['Method'] == 1) {
					$m = 'Cash';
				} else if($data['Method'] == 2) {
					$m = 'Card';
				} else if($data['Method'] == 3) {
					$m = 'Account';
				} else if($data['Method'] == 4) {
					$m = 'SNAP';
				} else if($data['Method'] == 5) {
					$m = 'Fuel Card';
				}
				$sheet->setCellValue('A'.$rows, $data['Name']);
				$sheet->setCellValue('B'.$rows, $data['Plate']);
				$sheet->setCellValue('C'.$rows, $data['Service_Name']);
				$sheet->setCellValue('D'.$rows, '£'.$data['Gross']);
				$sheet->setCellValue('E'.$rows, '£'.$data['Nett']);
				$sheet->setCellValue('F'.$rows, $m);
				$sheet->setCellValue('G'.$rows, date("d/m/Y H:i:s", strtotime($data['Processed_Time'])));
				$sheet->setCellValue('H'.$rows, $this->account->Account_GetInfo($data['AccountID'], "Name"));
				$rows++;
			}
			$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
			$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25);
			$styleArray = [
					'font' => [
							'bold' => true,
					],
					'alignment' => [
							'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					],
					'borders' => [
							'top' => [
									'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
					],
					'fill' => [
							'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
							'rotation' => 90,
							'startColor' => [
									'argb' => 'c41f45',
							],
							'endColor' => [
									'argb' => '9b1837',
							],
					],
			];
			$spreadsheet->getActiveSheet()->getStyle('A'.$rows.':H'.$rows)->applyFromArray($styleArray);
			$spreadsheet->getActiveSheet()->getStyle('A'.$rows.':H'.$rows)->getFont()->getColor()->setARGB('FFFFFF');
			$sheet->setCellValue('A'.$rows, 'Totals: ');
			$sheet->setCellValue('D'.$rows, '£'.number_format($totalGross, 2));
			$sheet->setCellValue('E'.$rows, '£'.number_format($totalNett, 2));
			// $rows++;
			//End spreadsheets
			$writer = new Xlsx($spreadsheet);
			$writer->save('php://output') ;
			$spreadsheet->disconnectWorksheets();
			unset($spreadsheet);

			$this->mysql = null;
			$this->user = null;
			$this->account = null;
		}
		//
		function UpdatePayment_GET($Ref)
		{
			$this->mysql = new MySQL;

			$stmt = $this->mysql->dbc->prepare("SELECT * FROM transactions WHERE Uniqueref = ?");
			$stmt->bindParam(1, $Ref);
			$stmt->execute();
			$result = $stmt->fetch(\PDO::FETCH_ASSOC);

			echo json_encode($result);

			$this->mysql = null;
		}
		function UpdatePayment($Ref, $Time)
		{
			$this->mysql = new MySQL;

			$stmt = $this->mysql->dbc->prepare("UPDATE transactions SET Processed_Time = ? WHERE Uniqueref = ?");
			$stmt->bindParam(1, $Time);
			$stmt->bindParam(2, $Ref);
			$stmt->execute();

			if($stmt->rowCount() > 0) {
				echo 1;
			} else {
				echo 0;
			}

			$this->mysql = null;
		}
	}
?>
