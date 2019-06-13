<?php
	namespace ParkingManager;
	class Payment
	{
		protected $mysql;

    function PaymentOptions($Plate)
		{
			$this->mysql = new MySQL;
			$this->account = new Account;
			$this->etp = new ETP;
			$accCk = $this->account->Account_Check($Plate);
			$snapCk = $this->etp->Check_SNAP($Plate);
			$html = "";

			if($snapCk == TRUE) {
				$chk = '<a class="nav-item nav-link" id="nav-snap-tab" data-toggle="tab" href="#nav-snap" role="tab" aria-controls="nav-snap" aria-selected="false"><i class="fas fa-check-circle" style="color: green;"></i> SNAP</a>';
			} else {
				$chk = '<a class="nav-item nav-link disabled" id="nav-snap-tab" data-toggle="tab" href="#nav-snap" role="tab" aria-controls="nav-snap" aria-selected="false"><i class="fas fa-times-circle" style="color: red;"></i> SNAP</a>';
			}

			$html .= '<nav>
			            <div class="nav nav-tabs" id="nav-tab" role="tablist">
			              <a class="nav-item nav-link active" id="nav-cash-tab" data-toggle="tab" href="#nav-cash" role="tab" aria-controls="nav-cash" aria-selected="true"><i class="fa fa-money-bill-wave"></i> Cash</a>
			              <a class="nav-item nav-link" id="nav-card-tab" data-toggle="tab" href="#nav-card" role="tab" aria-controls="nav-card" aria-selected="false"><i class="far fa-credit-card"></i> Card</a>
			              <a class="nav-item nav-link" id="nav-acc-tab" data-toggle="tab" href="#nav-acc" role="tab" aria-controls="nav-acc" aria-selected="false"><i class="fas fa-file-invoice"></i> Account</a>';
			$html .= $chk;
			$html .= '<a class="nav-item nav-link" id="nav-fuel-tab" data-toggle="tab" href="#nav-fuel" role="tab" aria-controls="nav-fuel" aria-selected="false"><i class="fas fa-gas-pump"></i> Fuel Card</a>
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


			echo $html;
			$this->mysql = null;
			$this->account = null;
			$this->etp = null;
		}
	}

?>
