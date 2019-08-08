<?php
	namespace ParkingManager;
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
			$campus = $this->user->Info("campus");

			$Cash = "";
			$Card = "";
			$Account = "";
			$SNAP = "";
			$Fuel = "";

			$stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_campus = ? AND service_active = 1 AND service_deleted < 1 AND service_expiry = ? AND service_vehicles = ? ORDER BY service_price_gross ASC");
			$stmt->bindParam(1, $campus);
			$stmt->bindParam(2, $Expiry);
			$stmt->bindParam(3, $Type);
			$stmt->execute();

			$stmt2 = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE service_campus = ? AND service_active = 1 AND service_deleted < 1 AND service_vehicles = 0 ORDER BY service_group, service_price_gross ASC");
			$stmt2->bindParam(1, $campus);
			$stmt2->execute();

			$Cash .= '<select class="form-control form-control-lg" name="Payment_Service_Cash" id="Payment_Service_Cash">';
			$Card .= '<select class="form-control form-control-lg" name="Payment_Service_Card" id="Payment_Service_Card">';
			$Account .= '<select class="form-control form-control-lg" name="Payment_Service_Account" id="Payment_Service_Account">';
			$SNAP .= '<select class="form-control form-control-lg" name="Payment_Service_SNAP" id="Payment_Service_SNAP">';
			$Fuel .= '<select class="form-control form-control-lg" name="Payment_Service_Fuel" id="Payment_Service_Fuel">';
			foreach ($stmt->fetchAll() as $row) {
				if($row['service_cash'] == 1) {
					$Cash .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
				}

				if($row['service_card'] == 1) {
					$Card .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
				}

				if($row['service_account'] == 1) {
					$Account .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
				}

				if($row['service_snap'] == 1) {
					$SNAP .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
				}

				if($row['service_fuel'] == 1) {
					$Fuel .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
				}
			}
			$Cash .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
			$Card .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
			$Account .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
			$SNAP .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
			$Fuel .= '<option value="unchecked" style="color: red;">-- Misc Services --</option>';
			foreach ($stmt2->fetchAll() as $row) {
				if($row['service_cash'] == 1) {
					$Cash .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
				}

				if($row['service_card'] == 1) {
					$Card .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
				}

				if($row['service_account'] == 1) {
					$Account .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
				}

				if($row['service_snap'] == 1) {
					$SNAP .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
				}

				if($row['service_fuel'] == 1) {
					$Fuel .= '<option value="'.$row['id'].'">'.$row['service_name'].' - £'.$row['service_price_gross'].'</option>';
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

			$Site = $this->user->Info("campus");
			$Author = $this->user->Info("first_name");
			$uid = $this->user->Info("id");
			$Service_Name = $this->Payment_ServiceInfo($Service, "service_name");
			$Ticket_Name = $this->Payment_ServiceInfo($Service, "service_ticket_name");
			$Service_Settlement_Group = $this->Payment_ServiceInfo($Service, "service_settlement_group");
			$Service_Settlement_Multi = $this->Payment_ServiceInfo($Service, "service_settlement_multi");
			$Service_Group = $this->Payment_ServiceInfo($Service, "service_group");
			$Service_Gross = $this->Payment_ServiceInfo($Service, "service_price_gross");
			$Service_Nett = $this->Payment_ServiceInfo($Service, "service_price_net");
			$Uniqueref = $uid.date("YmdHis").mt_rand(1111, 9999).$Site;
			$Processed = date("Y-m-d H:i:s");

			$stmt = $this->mysql->dbc->prepare("INSERT INTO pm_transactions (id, Uniqueref, Parkingref, Site, Method, Plate, Name, Service, Service_Name, Service_Ticket_Name, Service_Group, Gross, Nett, Processed_Time, Vehicle_Capture_Time, Vehicle_Expiry_Time, Ticket_Printed, AccountID, ETPID, Deleted, Deleted_Comment, Settlement_Group, Settlement_Multi, Author, FuelCard_Type, FuelCard_No, FuelCard_Ex, Last_Updated)
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
		function Proccess_Transaction($Method, $Type, $Ref, $Plate, $Name, $Trl, $Time, $VehType, $Service, $Account_ID = '', $FuelCardNo = '', $FuelCardExpiry = '', $FuelCardRC = '')
		{
			$this->vehicles = new Vehicles;
			$this->etp = new ETP;
			$this->pm = new PM;
			$this->user = new User;
			$name = $this->user->Info("first_name");
			$Service_Expiry = $this->Payment_ServiceInfo($Service, "service_expiry");
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
					$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
					$ETP = $this->etp->Proccess_Transaction_SNAP($ETPID, $Plate, $Name);
					if($ETP != FALSE) {
						// Create Parking Record
						$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
						// Create Payment Record
						$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry);
						$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
						if($Payment != "UNSUCCESSFUL") {
							echo json_encode(array('Result' => 1, 'Ref' => $Payment));
							$this->pm->POST_Notifications("A SNAP Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');

						}
					} else {
						echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the transaction, please try again or seek alternative payment method.'));
					}
				} else if($Method == 5) {
					$CardChk = substr($FuelCardNo, "0", "6");
					if ($CardChk == '704310' AND $FuelCardRC == "90") {
						$CardType = 1; // DKV
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '704310' AND $FuelCardRC != "90") {
						echo json_encode(array('Result' => 2, 'Msg' => '<b>ParkingManager</b> has identified that this card is DKV, however the Restriction Code is not 90 and has therefore been refused.'));
					} else if ($CardChk == '707821') {
						$CardType = 2; // Key Fuels
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '789666') {
						$CardType = 2; // Key Fuels
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '706000') {
						$CardType = 3; // UTA
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '700048') {
						$CardType = 4; // MORGAN
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '708284') {
						$CardType = 4; // MORGAN
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '700676') {
						$CardType = 5; // BP
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							// Create Parking Record
							$VehRec = $this->vehicles->Parking_Record_Create($Ref, $Plate, $Trl, $Name, $Time, $Expiry, $VehType, $Account_ID);
							// Create Payment Record
							$Payment = $this->New_Transaction($VehRec, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
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
					$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
					$ETP = $this->etp->Proccess_Transaction_SNAP($ETPID, $Plate, $Name);
					if($ETP != FALSE) {
						$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
						// Create Payment Record
						$Payment = $this->New_Transaction($Ref, $Method, $Plate,  $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType = null, $FuelCardNo = null, $FuelCardExpiry = null);
						$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
						$this->vehicles->ExpiryUpdate($Ref, $Expiry);
						if($Payment != "UNSUCCESSFUL") {
							echo json_encode(array('Result' => 1, 'Ref' => $Payment));
							$this->pm->POST_Notifications("A SNAP Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');

						}
					} else {
						echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the transaction, please try again or seek alternative payment method.'));
					}
				} else if($Method == 5) {
					$CardChk = substr($FuelCardNo, "0", "6");
					if ($CardChk == '704310' AND $FuelCardRC == "90") {
						$CardType = 1; // DKV
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '704310' AND $FuelCardRC != "90") {
						echo json_encode(array('Result' => 2, 'Msg' => '<b>ParkingManager</b> has identified that this card is DKV, however the Restriction Code is not 90 and has therefore been refused.'));
					} else if ($CardChk == '707821') {
						$CardType = 2; // Key Fuels
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '789666') {
						$CardType = 2; // Key Fuels
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '706000') {
						$CardType = 3; // UTA
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '700048') {
						$CardType = 4; // MORGAN
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '708284') {
						$CardType = 4; // MORGAN
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
						}
					} else if ($CardChk == '700676') {
						$CardType = 5; // BP
						$ETPID = $this->Payment_ServiceInfo($Service, "service_etpid");
						$ETP = $this->etp->Proccess_Transaction_Fuel($ETPID, $Plate, $Name, $FuelCardNo, $FuelCardExpiry);
						if($ETP != FALSE) {
							$ANPR = $this->vehicles->Info($Ref, 'ANPRRef');
							// Create Payment Record
							$Payment = $this->New_Transaction($Ref, $Method, $Plate, $Name, $Service, $Account_ID = null, $ETP, $Time, $Expiry, $CardType, $FuelCardNo, $FuelCardExpiry);
							$this->vehicles->ANPR_PaymentUpdate($ANPR, $Expiry);
							$this->vehicles->ExpiryUpdate($Ref, $Expiry);
							if($Payment != "UNSUCCESSFUL") {
								echo json_encode(array('Result' => 1, 'Ref' => $Payment));
								$this->pm->POST_Notifications("A Fuel Card Payment has successfully been processed by ".$name.", Ref: ".$Payment, '0');
							}
						} else {
							echo json_encode(array('Result' => 2, 'Msg' => 'ETP have refused the fuel card transaction, please try again or seek alternative payment method.'));
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
		function Payment_ServiceInfo($key, $what)
		{
		 $this->mysql = new MySQL;

		 $stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_services WHERE id = ?");
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
			$Card = $this->Fuel_String_Prepare($string, ";", "=");
			$expiry = $this->Fuel_String_Prepare($string, "=", "?");
			$expiry_yr = substr($expiry, "0", "2");
			$expiry_m = substr($expiry, "2", "2");
			$rc = substr($expiry, "6", "2");
			$expiry = $expiry_m."/20".$expiry_yr;

			$result = [
				'cardno' => $Card,
				'expiry' => $expiry,
				'rc' => $rc
			];

			echo json_encode($result);
		}
		// List all payments attached to vehicle
		function PerVehPayments($ref)
		{
			$this->mysql = new MySQL;
			$stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_transactions WHERE Parkingref = ? AND Deleted < 1 ORDER BY Processed_Time DESC");
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
	                    <th scope="col"><button type="button" class="btn btn-sm btn-danger float-right" id="PaymentOnUpdate"><i class="fa fa-pound-sign"></i> New Payment</button></th>
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
					<td>'.date("d/H:i", strtotime($row['Processed_Time'])).'</td>
					<td>'.$row['Ticket_Printed'].'</td>
					<td>'.$row['Author'].'</td>
					<td>
						<div class="btn-group float-right" role="group" aria-label="Options">
							<button type="button" class="btn btn-danger" onClick="Print_Ticket('.$ref.')"><i class="fa fa-print"></i></button>
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

			$stmt = $this->mysql->dbc->prepare("SELECT * FROM pm_transactions WHERE Uniqueref = ?");
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
			$MealCount = $this->Payment_ServiceInfo($Service, "service_meal_amount");
			$ShowerCount = $this->Payment_ServiceInfo($Service, "service_shower_amount");
			$Group = $result['Service_Group'];
			$PRef = $result['Parkingref']; // Parking Ref not Payment $Ref is payment
			$ExitKey = $this->vehicles->Info($PRef, "ExitKey");
			$DiscCount = $this->Payment_ServiceInfo($Service, "service_discount_amount");
			$WifiCount = $this->Payment_ServiceInfo($Service, "service_wifi_amount");
			$Account_ID = $result['AccountID'];
			$Printed = $result['Ticket_Printed'];
			$ProcessedTime = $result['Processed_Time'];

			$this->ticket->Direction($TicketName, $Gross, $Nett, $Name = '', $Plate, $Ref, $Date, $Expiry, $Type, $MealCount, $ShowerCount, $Group, $ExitKey, $DiscCount, $WifiCount, $Account_ID, $Printed, $ProcessedTime);

			$this->mysql = null;
			$this->ticket = null;
			$this->vehicles = null;
		}
		// Transaction History
		function Transaction_List($Start, $End)
		{
			$this->mysql = new MySQL;
			$this->user = new User;
			$this->account = new Account;

			$Start = date("Y-m-d 00:00:00", strtotime($Start));
			$End = date("Y-m-d 23:59:59", strtotime($End));
			$column = array('Name', 'Plate', 'Service_Name', 'Gross', 'Nett', 'Method', 'Processed_Time', 'AccountID', 'Author');
			$search = $_POST['search']['value'];
			$search = '%'.$search.'%';
			$Site = $this->user->Info("campus");


			$query = 'SELECT * FROM pm_transactions ';

				if(isset($Start) && isset($End) && $Start != '' && $End != '')
				{
				 $query .= 'WHERE Site = '.$Site.' AND Processed_Time BETWEEN ? AND ? ';
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
											<button type="button" class="btn btn-danger" onClick="DeleteTransaction('.$row['Uniqueref'].')"><i class="fa fa-trash"></i></button>
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
				$sub_array[] = $this->account->Account_GetInfo($row['AccountID'], "account_name");
				$sub_array[] = $row['Author'];
				$sub_array[] = $options;
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

			$stmt1 = $this->mysql->dbc->prepare("SELECT * FROM pm_transactions WHERE Uniqueref = ?");
			$stmt1->bindParam(1, $ref);
			$stmt1->execute();
			$record = $stmt1->fetch(\PDO::FETCH_ASSOC);
			$serviceEx = $this->Payment_ServiceInfo($record['Service'], "service_expiry");
			$parkingref = $record['Parkingref'];
			$expiry = $this->vehicles->Info($parkingref, "Expiry");
			$anpr = $this->vehicles->Info($parkingref, "ANPRRef");
			$new_Expiry = date('Y-m-d H:i:s', strtotime($expiry.' - '.$serviceEx.' hours'));

			if($record['Method'] > 3) {
				$etpid = $record['ETPID'];
				$delSnap = $this->etp->DeleteTransaction($etpid);
				if($delSnap == TRUE) {
					$stmt = $this->mysql->dbc->prepare("UPDATE pm_transactions SET Deleted = 1 WHERE Uniqueref = ?");
					$stmt->bindParam(1, $ref);
					$stmt->execute();
					$this->vehicles->ExpiryUpdate($parkingref, $new_Expiry);
					$this->vehicles->ANPR_PaymentUpdate($anpr, $new_Expiry);
					echo $stmt->rowCount();
				} else {
					echo "REFUSED";
				}
			} else {
				$stmt = $this->mysql->dbc->prepare("UPDATE pm_transactions SET Deleted = 1 WHERE Uniqueref = ?");
				$stmt->bindParam(1, $ref);
				$stmt->execute();
				$this->vehicles->ExpiryUpdate($parkingref, $new_Expiry);
				$this->vehicles->ANPR_PaymentUpdate($anpr, $new_Expiry);
				echo $stmt->rowCount();
			}


			$this->mysql = null;
			$this->etp = null;
			$this->vehicles = null;
		}
	}
?>
