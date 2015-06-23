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
			$servicesPrices[$key]['SFUIN'] = array();
			$servicesPrices[$key]['SFUOUT'] = array();
			$servicesPrices[$key]['MDUIN'] = array();
			$servicesPrices[$key]['MDUOUT'] = array();
			foreach ($allServices as $keyservice => $service) {
				$servicesPrices[$key]['SFUIN'][$service['Service']['name']] = $service['Service']['sfu_in'];
				$servicesPrices[$key]['SFUOUT'][$service['Service']['name']] = $service['Service']['sfu_out'];
				$servicesPrices[$key]['MDUIN'][$service['Service']['name']] = $service['Service']['mdu_in'];
				$servicesPrices[$key]['MDUOUT'][$service['Service']['name']] = $service['Service']['mdu_in'];
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
			'SFUIN'=>array('sfuinTot'=>0,'tv'=>$tvServices,'internet'=>$netServices,'phone'=>$phServices,'xfinity_home'=>$xhServices),
			'SFUOUT'=>array('sfuouTot'=>0,'tv'=>$tvServices,'internet'=>$netServices,'phone'=>$phServices,'xfinity_home'=>$xhServices),	
			'MDUIN'=>array('mduinTot'=>0,'tv'=>$tvServices,'internet'=>$netServices,'phone'=>$phServices,'xfinity_home'=>$xhServices),	
			'MDUOUT'=>array('mduouTot'=>0,'tv'=>$tvServices,'internet'=>$netServices,'phone'=>$phServices,'xfinity_home'=>$xhServices)
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

		$comissionByUserTemp = array();
		$comissionByUser = array();

		$salesforpayroll = $this->Sale->find('all', array('conditions'=>$conditions));

		foreach ($salesforpayroll as $key => $sale) {
			if (!isset($comissionByUserTemp[$sale['User']['id']])) {
				$comissionByUserTemp[$sale['User']['id']] = $catSales;
				$comissionByUserTemp[$sale['User']['id']]['userTot'] = 0;
			}
			switch ($sale['Sale']['category']) {
				case 'SFU-IN':
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
					break;
				case 'SFU-OUT':
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
					$comissionByUserTemp[$sale['Sale']['user_id']]['SFUOUT']['sfuouTot'] += 1;
					$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += 1;
					break;
				case 'MDU-IN':
					if ($sale['Sale']['tv'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUIN'][$sale['Sale']['tv']] *
									$sale['User']['comission']) / 100 );
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['tv'][$sale['Sale']['tv']] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['tv']['Total'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['sfuinTot'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['internet'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUIN'][$sale['Sale']['internet']] *
									$sale['User']['comission']) / 100 );
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['internet'][$sale['Sale']['internet']] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['internet']['Total'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['sfuinTot'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['phone'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUIN'][$sale['Sale']['phone']] *
									$sale['User']['comission']) / 100 );
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['phone'][$sale['Sale']['phone']] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['phone']['Total'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['sfuinTot'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUIN'][$sale['Sale']['xfinity_home']] *
									$sale['User']['comission']) / 100 );
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['xfinity_home']['Total'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUIN']['sfuinTot'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					break;
				case 'MDU-OUT':
					if ($sale['Sale']['tv'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUOUT'][$sale['Sale']['tv']] *
									$sale['User']['comission']) / 100 );
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['tv'][$sale['Sale']['tv']] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['tv']['Total'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['sfuinTot'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['internet'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUOUT'][$sale['Sale']['internet']] *
									$sale['User']['comission']) / 100 );
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['internet'][$sale['Sale']['internet']] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['internet']['Total'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['sfuinTot'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['phone'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUOUT'][$sale['Sale']['phone']] *
									$sale['User']['comission']) / 100 );
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['phone'][$sale['Sale']['phone']] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['phone']['Total'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['sfuinTot'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					if ($sale['Sale']['xfinity_home'] != 'Not Purchased') {
						$comiss  =	( ( $servicesPrices[$sale['Sale']['region_id']]['MDUOUT'][$sale['Sale']['xfinity_home']] *
									$sale['User']['comission']) / 100 );
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['xfinity_home'][$sale['Sale']['xfinity_home']] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['xfinity_home']['Total'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['MDUOUT']['sfuinTot'] += $comiss;
						$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] += $comiss;
					}
					break;
			}

			$comissionByUserTemp[$sale['Sale']['user_id']]['subtotal'] = 
				$comissionByUserTemp[$sale['Sale']['user_id']]['userTot'] + $sale['User']['bonus'];

			$comissionByUserTemp[$sale['Sale']['user_id']]['savings'] = 
				$comissionByUserTemp[$sale['Sale']['user_id']]['subtotal'] * 
					( $sale['User']['saving'] / 100 );
		}

		$this->loadModel('User');
		$this->loadModel('Advance');
		$thisKey = 0;
		foreach ($comissionByUserTemp as $key => $comissions) {
			$comissionByUser[$thisKey] = $comissions;
			$xpto = $this->User->find('first',array('conditions'=>array('User.id'=>$key)));
			$comissionByUser[$thisKey]['User'] = $xpto['User'];
			if (!count($xpto['Advance'])-1 < 0)
				$comissionByUser[$thisKey]['Advance'] = $xpto['Advance'][count($xpto['Advance'])-1];
			else
				$comissionByUser[$thisKey]['Advance']['balance'] = 0;
			if (!count($xpto['Saving'])-1 < 0)
				$comissionByUser[$thisKey]['Advance'] = $xpto['Advance'][count($xpto['Advance'])-1];
			else
				$comissionByUser[$thisKey]['Advance']['balance'] = 0;
			$comissionByUser[$thisKey]['totaldue'] = 
				$comissions['subtotal'] - $comissions['savings'] - $comissions['savings'];
			$thisKey++;
		}

		$arrReturn['data'] = $comissionByUser;
		echo json_encode($arrReturn);
		exit;
	}

}