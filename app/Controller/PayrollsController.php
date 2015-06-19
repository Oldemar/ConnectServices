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
		$users = $this->User->find('list', array('conditions'=>array('User.role_id'=>array('4','5','6'))));
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
		} else {
			$cond1 = "";
		}

		if (!empty($this->data['start'])) {
			$cond2['Sale.sales_date >='] = date('Y-m-d H:i:s',strtotime($this->data['start'].' 00:00:00'));
		} else {
			$cond2 = "";
		}

		if (!empty($this->data['end'])) {
			$cond3['Sale.sales_date <='] = date('Y-m-d H:i:s',strtotime($this->data['end'].' 23:59:59'));
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

		$this->loadModel('Region');
		$regions =  $this->Region->find('list');
		$servicesPrices = array();
		$this->loadModel('Service');
		$allServices = $this->Service->find('all');
		foreach ($regions as $key => $xpto) {
			$servicesPrices[$key]['SFU-IN'] = array();
			$servicesPrices[$key]['SFU-OUT'] = array();
			$servicesPrices[$key]['MDU-IN'] = array();
			$servicesPrices[$key]['MDU-OUT'] = array();
			foreach ($allServices as $keyservice => $service) {
				$servicesPrices[$key]['SFU-IN'][$service['Service']['name']] = $service['Service']['sfu_in'];
				$servicesPrices[$key]['SFU-OUT'][$service['Service']['name']] = $service['Service']['sfu_out'];
				$servicesPrices[$key]['MDU-IN'][$service['Service']['name']] = $service['Service']['mdu_in'];
				$servicesPrices[$key]['MDU-OUT'][$service['Service']['name']] = $service['Service']['mdu_in'];
			}
		}

		$this->set('servicesPrices',$servicesPrices);

		$this->autoRender = false;

	    $tvServices = array(
	    		'Total'=>0,
	            'Basic TV'=>0,
	            'Economy TV'=>0,
	            'Starter TV'=>0,
	            'Preferred TV'=>0,
	            'Premier TV'=>0);

	    $netServices = array(
	    		'Total'=>0,
	            'Economy Internet'=>0,
	            'Performance Internet'=>0,
	            'Blast Internet'=>0,
	            'Extreme Internet'=>0);

	    $phServices = array(
	    		'Total'=>0,
	            'Local Phone'=>0,
	            'Unlimited Phone'=>0);

	    $xhServices = array(
	    		'Total'=>0,
	            'XH 300'=>0,
	            'XH 350'=>0,
	            'XH 100'=>0,
	            'XH 150'=>0);

 		$catSales = array(
			'SFU-IN'=>array('sfuinTot'=>0,'tv'=>$tvServices,'internet'=>$netServices,'phone'=>$phServices,'xfinity_home'=>$xhServices),
			'SFU-OUT'=>array('sfuouTot'=>0,'tv'=>$tvServices,'internet'=>$netServices,'phone'=>$phServices,'xfinity_home'=>$xhServices),	
			'MDU-IN'=>array('mduinTot'=>0,'tv'=>$tvServices,'internet'=>$netServices,'phone'=>$phServices,'xfinity_home'=>$xhServices),	
			'MDU-OUT'=>array('mduouTot'=>0,'tv'=>$tvServices,'internet'=>$netServices,'phone'=>$phServices,'xfinity_home'=>$xhServices)
			);

		$this->loadModel('Sale');

		if (isset($this->data['regionID']) && !empty($this->data['regionID'])) {
			$cond1['Sale.region_id'] = $this->data['regionID'];
		} else {
			$cond1 = "";
		}

		if (!empty($this->data['start'])) {
			$cond2['Sale.sales_date >='] = date('Y-m-d H:i:s',strtotime($this->data['start'].' 00:00:00'));
		} else {
			$cond2 = "";
		}

		if (!empty($this->data['end'])) {
			$cond3['Sale.sales_date <='] = date('Y-m-d H:i:s',strtotime($this->data['end'].' 23:59:59'));
		} else {
			$cond3 = "";
		}

		if (isset($this->data['userID']) && !empty($this->data['userID'])) {
			$cond4['Sale.user_id'] = $this->data['userID'];
		} else {
			$cond4 = "";
		}
		$conditions = array('Sale.comissioned' => 0,'Sale.installed' => 1,$cond1,$cond2,$cond3,$cond4);

		$comissionByUser = array();
		$comissionByUser1 = array();

		$salesforpayroll = $this->Sale->find('all', array('conditions'=>$conditions));

		foreach ($salesforpayroll as $key => $sale) {
			if (!isset($comissionByUser[$sale['User']['id']])) {
				$comissionByUser[$sale['User']['id']] = $catSales;
				$comissionByUser[$sale['User']['id']]['userTot'] = 0;
				$comissionByUser[$sale['User']['id']]['name'] = $sale['User']['fullname'];
			}
			switch ($sale['Sale']['category']) {
				case 'SFU-IN':
					if ($sale['Sale']['tv'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-IN'][$sale['Sale']['tv']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['SFU-IN']['tv'][$sale['Sale']['tv']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-IN']['tv']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-IN']['sfuinTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['internet'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-IN'][$sale['Sale']['internet']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['SFU-IN']['internet'][$sale['Sale']['internet']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-IN']['internet']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-IN']['sfuinTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['phone'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-IN'][$sale['Sale']['phone']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['SFU-IN']['phone'][$sale['Sale']['phone']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-IN']['phone']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-IN']['sfuinTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-IN'][$sale['Sale']['xfinity_home']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['SFU-IN']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-IN']['xfinity_home']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-IN']['sfuinTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					break;
				case 'SFU-OUT':
					if ($sale['Sale']['tv'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-OUT'][$sale['Sale']['tv']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['tv'][$sale['Sale']['tv']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['tv']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['sfuouTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['internet'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-OUT'][$sale['Sale']['internet']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['internet'][$sale['Sale']['internet']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['internet']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['sfuouTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['phone'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-OUT'][$sale['Sale']['phone']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['phone'][$sale['Sale']['phone']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['phone']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['sfuouTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-OUT'][$sale['Sale']['xfinity_home']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['xfinity_home']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['sfuouTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					$comissionByUser[$sale['Sale']['user_id']]['SFU-OUT']['sfuouTot'] += 1;
					$comissionByUser[$sale['Sale']['user_id']]['userTot'] += 1;
					break;
				case 'MDU-IN':
					if ($sale['Sale']['tv'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-IN'][$sale['Sale']['tv']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['MDU-IN']['tv'][$sale['Sale']['tv']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-IN']['tv']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-IN']['sfuinTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['internet'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-IN'][$sale['Sale']['internet']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['MDU-IN']['internet'][$sale['Sale']['internet']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-IN']['internet']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-IN']['sfuinTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['phone'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-IN'][$sale['Sale']['phone']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['MDU-IN']['phone'][$sale['Sale']['phone']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-IN']['phone']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-IN']['sfuinTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-IN'][$sale['Sale']['xfinity_home']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['MDU-IN']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-IN']['xfinity_home']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-IN']['sfuinTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					break;
				case 'MDU-OUT':
					if ($sale['Sale']['tv'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-OUT'][$sale['Sale']['tv']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['MDU-OUT']['tv'][$sale['Sale']['tv']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-OUT']['tv']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-OUT']['sfuinTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['internet'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-OUT'][$sale['Sale']['internet']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['MDU-OUT']['internet'][$sale['Sale']['internet']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-OUT']['internet']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-OUT']['sfuinTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['phone'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-OUT'][$sale['Sale']['phone']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['MDU-OUT']['phone'][$sale['Sale']['phone']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-OUT']['phone']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-OUT']['sfuinTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-OUT'][$sale['Sale']['xfinity_home']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser[$sale['Sale']['user_id']]['MDU-OUT']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-OUT']['xfinity_home']['Total'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['MDU-OUT']['sfuinTot'] += $comiss;
						$comissionByUser[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					break;
			}

		}
		foreach ($salesforpayroll as $key => $sale) {
			if (!isset($comissionByUser1[$sale['User']['id']])) {
				$comissionByUser1[$sale['User']['id']] = $catSales;
				$comissionByUser1[$sale['User']['id']]['userTot'] = 0;
				$comissionByUser1[$sale['User']['id']]['name'] = $sale['User']['fullname'];
			}
			switch ($sale['Sale']['category']) {
				case 'SFU-IN':
					if ($sale['Sale']['tv'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-IN'][$sale['Sale']['tv']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-IN']['tv'][$sale['Sale']['tv']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-IN']['tv']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-IN']['sfuinTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['internet'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-IN'][$sale['Sale']['internet']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-IN']['internet'][$sale['Sale']['internet']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-IN']['internet']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-IN']['sfuinTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['phone'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-IN'][$sale['Sale']['phone']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-IN']['phone'][$sale['Sale']['phone']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-IN']['phone']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-IN']['sfuinTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-IN'][$sale['Sale']['xfinity_home']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-IN']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-IN']['xfinity_home']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-IN']['sfuinTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					break;
				case 'SFU-OUT':
					if ($sale['Sale']['tv'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-OUT'][$sale['Sale']['tv']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['tv'][$sale['Sale']['tv']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['tv']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['sfuouTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['internet'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-OUT'][$sale['Sale']['internet']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['internet'][$sale['Sale']['internet']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['internet']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['sfuouTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['phone'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-OUT'][$sale['Sale']['phone']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['phone'][$sale['Sale']['phone']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['phone']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['sfuouTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['SFU-OUT'][$sale['Sale']['xfinity_home']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['xfinity_home']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['sfuouTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					$comissionByUser1[$sale['Sale']['user_id']]['SFU-OUT']['sfuouTot'] += 1;
					$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += 1;
					break;
				case 'MDU-IN':
					if ($sale['Sale']['tv'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-IN'][$sale['Sale']['tv']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-IN']['tv'][$sale['Sale']['tv']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-IN']['tv']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-IN']['sfuinTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['internet'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-IN'][$sale['Sale']['internet']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-IN']['internet'][$sale['Sale']['internet']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-IN']['internet']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-IN']['sfuinTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['phone'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-IN'][$sale['Sale']['phone']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-IN']['phone'][$sale['Sale']['phone']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-IN']['phone']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-IN']['sfuinTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-IN'][$sale['Sale']['xfinity_home']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-IN']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-IN']['xfinity_home']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-IN']['sfuinTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					break;
				case 'MDU-OUT':
					if ($sale['Sale']['tv'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-OUT'][$sale['Sale']['tv']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-OUT']['tv'][$sale['Sale']['tv']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-OUT']['tv']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-OUT']['sfuinTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['internet'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-OUT'][$sale['Sale']['internet']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-OUT']['internet'][$sale['Sale']['internet']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-OUT']['internet']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-OUT']['sfuinTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['phone'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-OUT'][$sale['Sale']['phone']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-OUT']['phone'][$sale['Sale']['phone']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-OUT']['phone']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-OUT']['sfuinTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDU-OUT'][$sale['Sale']['xfinity_home']] *
									$sale['User']['comission']) / 100 );
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-OUT']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-OUT']['xfinity_home']['Total'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['MDU-OUT']['sfuinTot'] += $comiss;
						$comissionByUser1[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					break;
			}

		}
		
		$arrReturn['data'] = $comissionByUser;
		echo json_encode($arrReturn);
		exit;
	}

}