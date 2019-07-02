<?php
	namespace ParkingManager;
	class Payment
	{
		protected $mysql;

    function PaymentOptions($Plate) {
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
		function PaymentServices_Dropdown($Type, $Expiry, $Plate) {
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
	                <div class="col-8">
	                  <label>Fuel Card Number</label>
	                  <input type="text" class="form-control" placeholder="Fuel Card Number" id="Payment_FuelCard_Number">
	                </div>
	                <div class="col-4">
	                  <label>Expiration Date</label>
	                  <input type="text" class="form-control" placeholder="Expiry (02/2020)" id="Payment_FuelCard_Expiry">
	                </div>
                </div>
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
	}
?>
