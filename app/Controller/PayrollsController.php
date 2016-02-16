<?php
App::uses('AppController', 'Controller');
App::uses('CakeNumber','Utility');/**
 * Payrolls Controller
 *
 * @property Payroll $Payroll
 * @property PaginatorComponent $Paginator
 */
class PayrollsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Payroll->recursive = 0;
		$this->set('payrolls', $this->Paginator->paginate());
	}

/**
 * mypayrolls method
 *
 * @return void
 */
	public function mypayrolls($id) {
		$this->Payroll->recursive = 0;
		$this->set('payrolls', $this->Paginator->paginate('Payroll',array('Payroll.user_id'=>$id)));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Payroll->exists($id)) {
			throw new NotFoundException(__('Invalid payroll'));
		}
		$options = array('conditions' => array('Payroll.' . $this->Payroll->primaryKey => $id));
		$this->set('payroll', $this->Payroll->find('first', $options));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Payroll->exists($id)) {
			throw new NotFoundException(__('Invalid payroll'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Payroll->save($this->request->data)) {
				$this->Session->setFlash(__('The payroll has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The payroll could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Payroll.' . $this->Payroll->primaryKey => $id));
			$this->request->data = $this->Payroll->find('first', $options);
		}
	}

/**
 * listsalesforpayroll method
 *
 * @return void
 */
	public function listsales()
	{
		$this->loadModel('User');
		$users = $this->User->find('list', array('conditions'=>array('User.role_id !='=>array('1','2','8'))));
		$this->loadModel('Region');
		$regions = $this->Region->find('list');

		$this->set(compact('regions','users'));
	}

/**
 * listsalesAJAX method
 *
 * @return void
 */
	public function listsalesAJAX() {

		$this->autoRender = false;

		$this->loadModel('Sale');

		if (isset($this->data['regionID']) && !empty($this->data['regionID'])) {
			$cond1['Sale.region_id'] = $this->data['regionID'];
			$users = $this->User->find('list',array('conditions'=>array('User.role_id !='=>array('1','2','8'),'User.region_id'=>$this->data['regionID'])));
		} else {
			$cond1 = "";
		}

		if (!empty($this->data['start'])) {
			$cond2['Sale.instalation >='] = date('Y-m-d H:i:s',strtotime($this->data['start'].' 00:00:00'));
		} else {
			$cond2 = "";
		}

		if (!empty($this->data['end'])) {
			$cond3['Sale.instalation <='] = date('Y-m-d H:i:s',strtotime($this->data['end'].' 23:59:59'));
		} else {
			$cond3 = "";
		}

		if (isset($this->data['userID']) && !empty($this->data['userID'])) {
			$cond4['Sale.user_id'] = $this->data['userID'];
		} else {
			$cond4 = "";
		}
		$conditions = array('Sale.comissioned' => 0,$cond1,$cond2,$cond3,$cond4);
		$arrReturn['data'] = $this->Sale->find('all', array('conditions'=>$conditions));
		$this->set('conditions',$conditions);

		echo json_encode($arrReturn);
		exit;
	}


/**
 * previewpayroll method
 *
 * @return void
 */
	public function previewpayrollAJAX()
	{

		$arrResult = $this->calculateComission();
		$arrReturn['data'] = $arrResult['comissionByUser'];
		echo json_encode($arrReturn);
		exit;
	}

	public function savepayroll(){

		$arrResult = $this->calculateComission();
		$comissionByUser = $arrResult['comissionByUser'];
		$salesforpayroll = $arrResult['salesforpayroll'];

 		$this->loadModel('Saving');

		foreach ($comissionByUser as $key => $userPayroll) {
			$data['Payroll'][] = array(
				'payrolldate' => date('Y-m-d H:i:s',strtotime($this->data['start'].' 00:00:00')),
				'user_id' => $userPayroll['User']['id'],
				'saving' => $userPayroll['savings'],
				'bonus' => $userPayroll['User']['bonus'],
				'comission' => $userPayroll['subtotal'],
				'advance' => $userPayroll['Advance']['balance'],
				'totaldue' => $userPayroll['totaldue']
			);
			$lastsaving = $this->Saving->find('first', array(
					'conditions'=>array(
						'Saving.user_id'=>$userPayroll['User']['id']),
					'ORDER'=>'Saving.savingdate DESC'
				));
			$savingsBalance = (isset($lastsaving) && !empty($lastsaving) ? $lastsaving['Saving']['balance'] + $userPayroll['savings'] : $userPayroll['savings']);
			$lastAdvance = $this->Advance->find('first', array(
					'conditions'=>array(
						'Advance.user_id'=>$userPayroll['User']['id']),
					'ORDER'=>'Advance.advdate DESC'
				));
			$advBalance = (isset($lastAdvance) && !empty($lastAdvance) ? $lastAdvance['Advance']['balance'] : 0);
			$data['Saving'][] = array(
				'user_id' => $userPayroll['User']['id'],
				'savingdate' => date('Y-m-d H:i:s',strtotime($this->data['start'].' 00:00:00')),
				'saving' => $userPayroll['savings'],
				'balance' => $savingsBalance
			);
			if ( $userPayroll['totaldue'] < 0 ) {
				if ( $savingsBalance < -$userPayroll['totaldue'] ) {
					$saving = 0 - $savingsBalance;
					$advance = -$userPayroll['totaldue'] - $savingsBalance;
				} else {
					$saving = $userPayroll['totaldue'];
					$advance = 0;
				}
				$data['Saving'][] = array(
					'user_id' => $userPayroll['User']['id'],
					'savingdate' => date('Y-m-d H:i:s',strtotime($this->data['start'].' 00:00:00')),
					'saving' => $saving,
					'balance' => $savingsBalance + $saving,
					'notes'=>'Charge Back or Advance withdraw.'
				);
				if ($advance > 0){
					$data['Advance'][] = array(
						'user_id' => $userPayroll['User']['id'],
						'advdate' => date('Y-m-d H:i:s',strtotime($this->data['start'].' 00:00:00')),
						'received' => 1,
						'value' => $advance,
						'notes'=> 'Charge back or Advance balance not received.'
					); 
				}
			}
		}
/*
		$this->loadModel('Sale');
		foreach ($salesforpayroll as $key => $sale) {
			$data['Sale']['id'] = $sale['Sale']['id'];
			$data['Sale']['comissioned'] = 1;
			$data['Sale']['comission'] = $sale['Sale']['comission'];
			$this->Sale->save($data['Sale']);
		}
		$this->Payroll->saveMany($data['Payroll']);
		$this->Saving->saveMany($data['Saving']);
		$this->Advance->saveMany($data['Advance']);
*/
		echo '<pre>'.print_r($data,true).'</pre>';
	}

	private function calculateComission() {

		$this->loadModel('Region');
		$regions =  $this->Region->find('list');
		$servicesPrices = array();
		$this->loadModel('Service');
		foreach ($regions as $key => $xpto) {
			$servicesPrices[$key]['SFUIN'] = array();
			$servicesPrices[$key]['SFUOUT'] = array();
			$servicesPrices[$key]['MDUIN'] = array();
			$servicesPrices[$key]['MDUOUT'] = array();
			$servicesByRegion = $this->Service->find('all',array('conditions'=>array('region_id'=>$key)));
			foreach ($servicesByRegion as $keyservice => $service) {
				$servicesPrices[$key]['SFUIN'][$service['Service']['name']] = $service['Service']['sfu_in'];
				$servicesPrices[$key]['SFUOUT'][$service['Service']['name']] = $service['Service']['sfu_out'];
				$servicesPrices[$key]['MDUIN'][$service['Service']['name']] = $service['Service']['mdu_in'];
				$servicesPrices[$key]['MDUOUT'][$service['Service']['name']] = $service['Service']['mdu_out'];
			}
		}

		$this->autoRender = false;

	    $tvServices = array(
	    		'Total'=>0,
	            'Basic TV'=>0,
	            'Economy TV'=>0,
	            'Starter TV'=>0,
	            'Preferred TV'=>0,
	            'Premier TV'=>0
	            );

	    $netServices = array(
	    		'Total'=>0,
	            'Economy Internet'=>0,
	            'Performance Internet'=>0,
	            'Blast Internet'=>0,
	            'Extreme Internet'=>0
	            );

	    $phServices = array(
	    		'Total'=>0,
	            'Local Phone'=>0,
	            'Unlimited Phone'=>0
	            );

	    $xhServices = array(
	    		'Total'=>0,
	            'XH 300'=>0,
	            'XH 350'=>0,
	            'XH 100'=>0,
	            'XH 150'=>0
	            );

	    $xtBonus = array(
	    		'Total'=>0,
	            'Triple Bonus'=>0,
	            'Quad Bonus'=>0
	            );

 		$catSales = array(
			'SFUIN'=>array('sfuinTot'=>0,'tv'=>$tvServices,'internet'=>$netServices,'phone'=>$phServices,'xfinity_home'=>$xhServices,'bonus'=>$xtBonus),
			'SFUOUT'=>array('sfuouTot'=>0,'tv'=>$tvServices,'internet'=>$netServices,'phone'=>$phServices,'xfinity_home'=>$xhServices,'bonus'=>$xtBonus),	
			'MDUIN'=>array('mduinTot'=>0,'tv'=>$tvServices,'internet'=>$netServices,'phone'=>$phServices,'xfinity_home'=>$xhServices,'bonus'=>$xtBonus),	
			'MDUOUT'=>array('mduouTot'=>0,'tv'=>$tvServices,'internet'=>$netServices,'phone'=>$phServices,'xfinity_home'=>$xhServices,'bonus'=>$xtBonus)
			);

		$this->loadModel('Sale');

		if (isset($this->data['regionID']) && !empty($this->data['regionID'])) {
			$cond1['Sale.region_id'] = $this->data['regionID'];
		} else {
			$cond1 = "";
		}

		if (!empty($this->data['start'])) {
			$cond2['Sale.instalation >='] = date('Y-m-d H:i:s',strtotime($this->data['start'].' 00:00:00'));
		} else {
			$cond2 = "";
		}

		if (!empty($this->data['end'])) {
			$cond3['Sale.instalation <='] = date('Y-m-d H:i:s',strtotime($this->data['end'].' 23:59:59'));
		} else {
			$cond3 = "";
		}

		if (isset($this->data['userID']) && !empty($this->data['userID'])) {
			$cond4['Sale.user_id'] = $this->data['userID'];
		} else {
			$cond4 = "";
		}
		$conditions = array('Sale.comissioned' => 0,'Sale.installed' => 1,$cond1,$cond2,$cond3,$cond4);

		$comissionByUserTemp = array();
		$comissionByUser = array();

		$salesforpayroll = $this->Sale->find('all', array(
			'contain'=>array('User'=>array('Advance')),
			'conditions'=>$conditions));


		foreach ($salesforpayroll as $key => $sale) {
			$si_tq_bonus = $so_tq_bonus = $mi_tq_bonus = $mo_tq_bonus = 0;
			if (!isset($comissionByUserTemp[$sale['User']['id']])) {
				$comissionByUserTemp[$sale['User']['id']] = $catSales;
				$comissionByUserTemp[$sale['User']['id']]['userTot'] = 0;
				$comissionByUserTemp[$sale['User']['id']]['bonusTot'] = 0;
			}
			if ($sale['Sale']['category'] == 'SFU-IN') {
				if ($sale['Sale']['tv'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFUIN'][$sale['Sale']['tv']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['tv'][$sale['Sale']['tv']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['tv']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['sfuinTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['internet'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFUIN'][$sale['Sale']['internet']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['internet'][$sale['Sale']['internet']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['internet']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['sfuinTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['phone'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFUIN'][$sale['Sale']['phone']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['phone'][$sale['Sale']['phone']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['phone']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['sfuinTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFUIN'][$sale['Sale']['xfinity_home']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['xfinity_home']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['sfuinTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['bonus'] != 'None') {
					$comiss = $servicesPrices[$sale['Sale']['region_id']]['SFUIN'][$sale['Sale']['bonus']];
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['bonus'][$sale['Sale']['bonus']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['bonus']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUIN']['sfuinTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['bonusTot'] += $comiss;
				}
			} elseif ($sale['Sale']['category'] == 'SFU-OUT') {
				if ($sale['Sale']['tv'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFUOUT'][$sale['Sale']['tv']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['tv'][$sale['Sale']['tv']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['tv']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['sfuouTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['internet'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFUOUT'][$sale['Sale']['internet']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['internet'][$sale['Sale']['internet']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['internet']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['sfuouTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['phone'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFUOUT'][$sale['Sale']['phone']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['phone'][$sale['Sale']['phone']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['phone']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['sfuouTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFUOUT'][$sale['Sale']['xfinity_home']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['xfinity_home']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['sfuouTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['bonus'] != 'None') {
					$comiss = $servicesPrices[$sale['Sale']['region_id']]['SFUOUT'][$sale['Sale']['bonus']];
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['bonus'][$sale['Sale']['bonus']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['bonus']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['sfuouTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['bonusTot'] += $comiss;
				}
			} elseif ($sale['Sale']['category'] == 'MDU-IN') {
				if ($sale['Sale']['tv'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUIN'][$sale['Sale']['tv']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['tv'][$sale['Sale']['tv']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['tv']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['mduinTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['internet'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUIN'][$sale['Sale']['internet']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['internet'][$sale['Sale']['internet']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['internet']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['mduinTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['phone'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUIN'][$sale['Sale']['phone']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['phone'][$sale['Sale']['phone']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['phone']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['mduinTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUIN'][$sale['Sale']['xfinity_home']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['xfinity_home']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['mduinTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}

				if ($sale['Sale']['bonus'] != 'None') {
					$comiss = $servicesPrices[$sale['Sale']['region_id']]['MDUIN'][$sale['Sale']['bonus']];
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['bonus'][$sale['Sale']['bonus']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['bonus']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['mduinTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['bonusTot'] += $comiss;
				}
			} elseif ($sale['Sale']['category'] == 'MDU-OUT') {
				if ($sale['Sale']['tv'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUOUT'][$sale['Sale']['tv']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['tv'][$sale['Sale']['tv']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['tv']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['mduouTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['internet'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUOUT'][$sale['Sale']['internet']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['internet'][$sale['Sale']['internet']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['internet']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['mduouTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['phone'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUOUT'][$sale['Sale']['phone']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['phone'][$sale['Sale']['phone']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['phone']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['mduouTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
					$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUOUT'][$sale['Sale']['xfinity_home']] *
								$sale['User']['comission']) / 100 );
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['xfinity_home']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['mduouTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
				}
				if ($sale['Sale']['bonus'] != 'None') {
					$comiss = $servicesPrices[$sale['Sale']['region_id']]['MDUOUT'][$sale['Sale']['bonus']];
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['bonus'][$sale['Sale']['bonus']] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['bonus']['Total'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['mduouTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
					$comissionByUserTemp[$sale['Sale']['user_id']]['bonusTot'] += $comiss;
				}
			}

			$comissionByUserTemp[$sale['Sale']['user_id']]['subtotal'] = $comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] + $sale['User']['bonus'];

			$comissionByUserTemp[$sale['Sale']['user_id']]['savings'] = $comissionByUserTemp[$sale['Sale']['user_id']]['subtotal'] * ( $sale['User']['saving'] / 100 );
			$comissionByUserTemp[$sale['Sale']['user_id']]['chargeback'] = 0;
		}

		$chargeback = array();
		$this->loadModel('User');
		$this->loadModel('Advance');
		$thisKey = 0;
		foreach ($comissionByUserTemp as $key => $comissions) {
			$comissionByUser[$thisKey] = $comissions;
			$advances = $this->Advance->find('all',array('conditions'=>array('Advance.user_id'=>$key,'Advance.charge'=>true,'Advance.received'=>false)));
			$userSale = $this->User->find('first', array('conditions'=>array('User.id'=>$key)));
			$comissionByUser[$thisKey]['User'] = $userSale['User'];
			$chargeback = 0;
			$arrChargeback = $this->Sale->find('all', array(
				'contain'=>array('Sale'),'fields'=> array('Sale.id','Sale.user_id','Sale.comission'),
				'conditions'=>array('Sale.comissioned'=>true,'Sale.chargeback'=>true,'Sale.charged'=>false,'Sale.user_id'=>$key)
			));

			/*
			*     Charge Back 
			*/
			foreach ($arrChargeback as $key => $valChargeBack) {
				$chargeback += $valChargeBack['Sale']['comission'];
			}
			$comissionByUser[$thisKey]['chargeback'] = ( isset( $chargeback ) ? $chargeback : 0 );

			/*
			*      Calculate Advance balance to charge
			*/
			$advBalance = 0;
			foreach ($advances as $key => $advanceRow) {
				$advBalance += $advanceRow['Advance']['value'];
			}
			$comissionByUser[$thisKey]['Advance']['balance'] = $advBalance;

			/*
			*     Final Total due
			*/
			$comissionByUser[$thisKey]['totaldue'] = 
				($comissions['subtotal'] - $comissions['savings']) - 
					$comissionByUser[$thisKey]['Advance']['balance'] - 
					$comissionByUser[$thisKey]['chargeback'];
			$thisKey++;
		}

		return array('comissionByUser'=>$comissionByUser,'salesforpayroll'=>$salesforpayroll,'chargeback'=>$chargeback,'advances'=>$advances);		
	}

}