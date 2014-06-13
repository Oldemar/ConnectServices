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
 * listreceivables method
 *
 * @return void
 */
	public function listreceivables() {
		$this->loadModel('Receivable');
		$this->set('receivables',$this->Receivable->find('all', array(
			'conditions'=>array(
				'Receivable.user_id'=>$this->objLoggedUser->getID()))));

	}

/**
 * new method
 *
 * @return void
 */
	public function generatepayroll() 
	{

		$this->loadModel('Service');
		$services = $this->Service->find('all');

		$region = $this->data['User']['region'];
		$start = date('Y-m-d H:i:s',strtotime($this->data['Payroll']['start'].' 00:00:00'));
		$end = date('Y-m-d H:i:s',strtotime($this->data['Payroll']['end'].' 23:59:59'));

		$this->loadModel('Comission');
		$comissionsByUser = $this->Comission->find('all', array(
			'conditions'=>array(
				'Comission.region'=>$region,
				'Comission.user_id'=>$this->objLoggedUser->getID()
				)));

		$this->loadModel('Sale');
		$sales = $this->Sale->find('all', array(
			'conditions'=>array(
				'AND'=>array(
					'Sale.comissioned'=> false,
					'Sale.installed'=>true,
					'User.region'=>$region,
					'Sale.sales_date >='=>$start,
					'Sale.sales_date <='=>$end
					))));

		$salesByUsers = array();
		$group = null;
		foreach ($sales as $key => $sale) 
		{
			if (!isset($salesByUsers[$sale['User']['id']]))
			{
				if ($sale['User']['topleader'] == $this->objLoggedUser->getID())
				{
					$salesByUsers[$sale['User']['id']]['User'] = $sale['User'];
					$userID = $sale['User']['id'];
					$salesByUsers[$userID]['Payroll']['user_id'] = $userID;
					$salesByUsers[$userID]['Payroll']['payrolldate'] = date('Y-m-d');
					$salesByUsers[$userID]['Payroll']['comission'] = 0;
					$salesByUsers[$userID]['Payroll']['saving'] = 0;
					$salesByUsers[$userID]['Payroll']['bonus'] = 0;
					$salesByUsers[$userID]['Payroll']['totaldue'] = 0;
					$salesByUsers[$userID]['Saving']['user_id'] = $userID;
					$salesByUsers[$userID]['Saving']['savingdate'] = date('Y-m-d');
					$salesByUsers[$userID]['Saving']['saving'] = 0;
				}
				else
				{
					if (!isset($salesByUsers[$sale['User']['topleader']]))
					{
						$tmpSale = $this->User->find('first', array(
							'conditions'=>array(
								'User.id'=>$sale['User']['topleader'])));
						$salesByUsers[$tmpSale['User']['id']]['User'] = $tmpSale['User'];
						$userID = $tmpSale['User']['id'];
						$salesByUsers[$userID]['Payroll']['user_id'] = $userID;
						$salesByUsers[$userID]['Payroll']['payrolldate'] = date('Y-m-d');
						$salesByUsers[$userID]['Payroll']['comission'] = 0;
						$salesByUsers[$userID]['Payroll']['saving'] = 0;
						$salesByUsers[$userID]['Payroll']['bonus'] = 0;
						$salesByUsers[$userID]['Payroll']['totaldue'] = 0;
						$salesByUsers[$userID]['Saving']['user_id'] = $userID;
						$salesByUsers[$userID]['Saving']['savingdate'] = date('Y-m-d');
						$salesByUsers[$userID]['Saving']['saving'] = 0;
					}
					else
					{
						$userID = $sale['User']['topleader'];
					}
				}
				foreach ($services as $key => $service) 
				{
					if ($service['Service']['group'] != $group) {
						if (!isset($salesByUsers[$userID]['Total']['Qty'][$service['Service']['group']]))
						{
							$salesByUsers[$userID]['Total']['Qty'][$service['Service']['group']] = 0;
							$salesByUsers[$userID]['Total']['Val'][$service['Service']['group']] = 0;
							$group = $service['Service']['group'];
						}
					}
					if (!isset($salesByUsers[$userID]['Total']['Qty'][$service['Service']['name']]))
					{
						$salesByUsers[$userID]['Total']['Qty'][$service['Service']['name']] = 0;
						$salesByUsers[$userID]['Total']['Val'][$service['Service']['name']] = 0;
					}
				}
			}
			else
			{
				$userID = $sale['User']['id'];
			}
			$salesByUsers[$userID]['Sale'][] = $sale['Sale'];
			$comission = 0;
			if ($sale['Sale']['tv'] != 'None') 
			{
				$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['tv']]++;
				$comission = $this->Service->getPrice($sale['Sale']['tv']) *
					$this->Comission->getPerc($sale['User']['region'],$salesByUsers[$userID]['User']['topleader'],$salesByUsers[$userID]['User']['role_id'],$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['tv']]);
				$salesByUsers[$userID]['Total']['Val'][$sale['Sale']['tv']] += $comission;
				$salesByUsers[$userID]['Total']['Qty']['TV']++;
				$salesByUsers[$userID]['Total']['Val']['TV'] += $comission;
				$salesByUsers[$userID]['Payroll']['comission'] += $comission;
				$salesByUsers[$userID]['Payroll']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
				$salesByUsers[$userID]['Payroll']['bonus'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['bonus'];
				$salesByUsers[$userID]['Saving']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
			}
			if ($sale['Sale']['internet'] != 'None') 
			{
				$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['internet']]++;
				$comission = $this->Service->getPrice($sale['Sale']['internet'])*
					$this->Comission->getPerc($sale['User']['region'],$salesByUsers[$userID]['User']['topleader'],$salesByUsers[$userID]['User']['role_id'],$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['internet']]);
				$salesByUsers[$userID]['Total']['Val'][$sale['Sale']['internet']] += $comission; 
				$salesByUsers[$userID]['Total']['Qty']['INTERNET']++;
				$salesByUsers[$userID]['Total']['Val']['INTERNET'] += $comission;
				$salesByUsers[$userID]['Payroll']['comission'] += $comission;
				$salesByUsers[$userID]['Payroll']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
				$salesByUsers[$userID]['Payroll']['bonus'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['bonus'];
				$salesByUsers[$userID]['Saving']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
			}
			if ($sale['Sale']['phone'] != 'None') 
			{
				$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['phone']]++;
				$comission = $this->Service->getPrice($sale['Sale']['phone'])*
					$this->Comission->getPerc($sale['User']['region'],$salesByUsers[$userID]['User']['topleader'],$salesByUsers[$userID]['User']['role_id'],$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['phone']]);
				$salesByUsers[$userID]['Total']['Val'][$sale['Sale']['phone']] += $comission; 
				$salesByUsers[$userID]['Total']['Qty']['PHONE']++;
				$salesByUsers[$userID]['Total']['Val']['PHONE'] += $comission;
				$salesByUsers[$userID]['Payroll']['comission'] += $comission;
				$salesByUsers[$userID]['Payroll']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
				$salesByUsers[$userID]['Payroll']['bonus'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['bonus'];
				$salesByUsers[$userID]['Saving']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
			}
			if ($sale['Sale']['homeSecurity'] != 'None') 
			{
				$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['homeSecurity']]++;
				$comission = $this->Service->getPrice($sale['Sale']['homeSecurity'])*
					$this->Comission->getPerc($sale['User']['region'],$salesByUsers[$userID]['User']['topleader'],$salesByUsers[$userID]['User']['role_id'],$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['phone']]);
				$salesByUsers[$userID]['Total']['Val'][$sale['Sale']['homeSecurity']] += $comission; 
				$salesByUsers[$userID]['Total']['Qty']['XFINITY_HOME']++;
				$salesByUsers[$userID]['Total']['Val']['XFINITY_HOME'] += $comission;
				$salesByUsers[$userID]['Payroll']['comission'] += $comission;
				$salesByUsers[$userID]['Payroll']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
				$salesByUsers[$userID]['Payroll']['bonus'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['bonus'];
				$salesByUsers[$userID]['Saving']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
			}

 		}

		$this->set('sales',$sales);
		$this->set('salesByUsers',$salesByUsers);
		$this->set('services',$services);

	}	

/**
 * new method
 *
 * @return void
 */
	public function generateadvance() 
	{

		$this->loadModel('Service');
		$services = $this->Service->find('all');

		$region = $this->data['User']['region'];
		$start = date('Y-m-d H:i:s',strtotime($this->data['Payroll']['start'].' 00:00:00'));
		$end = date('Y-m-d H:i:s',strtotime($this->data['Payroll']['end'].' 23:59:59'));

		$this->loadModel('Comission');
		$comissionsByUser = $this->Comission->find('all', array(
			'conditions'=>array(
				'Comission.region'=>$region,
				'Comission.user_id'=>$this->objLoggedUser->getID()
				)));

		$this->loadModel('Sale');
		$sales = $this->Sale->find('all', array(
			'conditions'=>array(
				'AND'=>array(
					'Sale.comissioned'=> false,
					'Sale.installed'=>true,
					'Sale.advanced'=>false,
					'User.region'=>$region,
					'Sale.sales_date >='=>$start,
					'Sale.sales_date <='=>$end
					))));

		$salesByUsers = array();
		$group = null;
		foreach ($sales as $key => $sale) 
		{
			if (!isset($salesByUsers[$sale['User']['id']]))
			{
				if ($sale['User']['topleader'] == $this->objLoggedUser->getID())
				{
					$salesByUsers[$sale['User']['id']]['User'] = $sale['User'];
					$userID = $sale['User']['id'];
					$salesByUsers[$userID]['Payroll']['user_id'] = $userID;
					$salesByUsers[$userID]['Payroll']['payrolldate'] = date('Y-m-d');
					$salesByUsers[$userID]['Payroll']['comission'] = 0;
					$salesByUsers[$userID]['Payroll']['saving'] = 0;
					$salesByUsers[$userID]['Payroll']['bonus'] = 0;
					$salesByUsers[$userID]['Payroll']['totaldue'] = 0;
					$salesByUsers[$userID]['Saving']['user_id'] = $userID;
					$salesByUsers[$userID]['Saving']['savingdate'] = date('Y-m-d');
					$salesByUsers[$userID]['Saving']['saving'] = 0;
					$salesByUsers[$userID]['Advance']['user_id'] = $userID;
					$salesByUsers[$userID]['Advance']['sale_id'] = $sale['Sale']['id'];
					$salesByUsers[$userID]['Advance']['advdate'] = date('Y-m-d');
					$salesByUsers[$userID]['Advance']['value'] = 0;
					$salesByUsers[$userID]['Advance']['received'] = 0;
				}
				else
				{
					if (!isset($salesByUsers[$sale['User']['topleader']]))
					{
						$tmpSale = $this->User->find('first', array(
							'conditions'=>array(
								'User.id'=>$sale['User']['topleader'])));
						$salesByUsers[$tmpSale['User']['id']]['User'] = $tmpSale['User'];
						$userID = $tmpSale['User']['id'];
						$salesByUsers[$userID]['Payroll']['user_id'] = $userID;
						$salesByUsers[$userID]['Payroll']['payrolldate'] = date('Y-m-d');
						$salesByUsers[$userID]['Payroll']['comission'] = 0;
						$salesByUsers[$userID]['Payroll']['saving'] = 0;
						$salesByUsers[$userID]['Payroll']['bonus'] = 0;
						$salesByUsers[$userID]['Payroll']['totaldue'] = 0;
						$salesByUsers[$userID]['Saving']['user_id'] = $userID;
						$salesByUsers[$userID]['Saving']['savingdate'] = date('Y-m-d');
						$salesByUsers[$userID]['Saving']['saving'] = 0;
						$salesByUsers[$userID]['Advance']['user_id'] = $userID;
						$salesByUsers[$userID]['Advance']['sale_id'] = $sale['Sale']['id'];
						$salesByUsers[$userID]['Advance']['advdate'] = date('Y-m-d');
						$salesByUsers[$userID]['Advance']['value'] = 0;
						$salesByUsers[$userID]['Advance']['received'] = 0;
					}
					else
					{
						$userID = $sale['User']['topleader'];
					}
				}
				foreach ($services as $key => $service) 
				{
					if ($service['Service']['group'] != $group) {
						if (!isset($salesByUsers[$userID]['Total']['Qty'][$service['Service']['group']]))
						{
							$salesByUsers[$userID]['Total']['Qty'][$service['Service']['group']] = 0;
							$salesByUsers[$userID]['Total']['Val'][$service['Service']['group']] = 0;
							$group = $service['Service']['group'];
						}
					}
					if (!isset($salesByUsers[$userID]['Total']['Qty'][$service['Service']['name']]))
					{
						$salesByUsers[$userID]['Total']['Qty'][$service['Service']['name']] = 0;
						$salesByUsers[$userID]['Total']['Val'][$service['Service']['name']] = 0;
					}
				}
			}
			else
			{
				$userID = $sale['User']['id'];
			}
			$salesByUsers[$userID]['Sale'][] = $sale['Sale'];
			$comission = 0;
			if ($sale['Sale']['tv'] != 'None') 
			{
				$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['tv']]++;
				$comission = $this->Service->getPrice($sale['Sale']['tv']) *
					$this->Comission->getPerc($sale['User']['region'],$salesByUsers[$userID]['User']['topleader'],$salesByUsers[$userID]['User']['role_id'],$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['tv']]);
				$salesByUsers[$userID]['Total']['Val'][$sale['Sale']['tv']] += $comission;
				$salesByUsers[$userID]['Total']['Qty']['TV']++;
				$salesByUsers[$userID]['Total']['Val']['TV'] += $comission;
				$salesByUsers[$userID]['Payroll']['comission'] += $comission;
				$salesByUsers[$userID]['Payroll']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
				$salesByUsers[$userID]['Payroll']['bonus'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['bonus'];
				$salesByUsers[$userID]['Saving']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
				$salesByUsers[$userID]['Advance']['value'] = $salesByUsers[$userID]['Payroll']['comission']*0.8;
			}
			if ($sale['Sale']['internet'] != 'None') 
			{
				$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['internet']]++;
				$comission = $this->Service->getPrice($sale['Sale']['internet'])*
					$this->Comission->getPerc($sale['User']['region'],$salesByUsers[$userID]['User']['topleader'],$salesByUsers[$userID]['User']['role_id'],$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['internet']]);
				$salesByUsers[$userID]['Total']['Val'][$sale['Sale']['internet']] += $comission; 
				$salesByUsers[$userID]['Total']['Qty']['INTERNET']++;
				$salesByUsers[$userID]['Total']['Val']['INTERNET'] += $comission;
				$salesByUsers[$userID]['Payroll']['comission'] += $comission;
				$salesByUsers[$userID]['Payroll']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
				$salesByUsers[$userID]['Payroll']['bonus'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['bonus'];
				$salesByUsers[$userID]['Saving']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
				$salesByUsers[$userID]['Advance']['value'] = $salesByUsers[$userID]['Payroll']['comission']*0.8;
			}
			if ($sale['Sale']['phone'] != 'None') 
			{
				$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['phone']]++;
				$comission = $this->Service->getPrice($sale['Sale']['phone'])*
					$this->Comission->getPerc($sale['User']['region'],$salesByUsers[$userID]['User']['topleader'],$salesByUsers[$userID]['User']['role_id'],$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['phone']]);
				$salesByUsers[$userID]['Total']['Val'][$sale['Sale']['phone']] += $comission; 
				$salesByUsers[$userID]['Total']['Qty']['PHONE']++;
				$salesByUsers[$userID]['Total']['Val']['PHONE'] += $comission;
				$salesByUsers[$userID]['Payroll']['comission'] += $comission;
				$salesByUsers[$userID]['Payroll']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
				$salesByUsers[$userID]['Payroll']['bonus'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['bonus'];
				$salesByUsers[$userID]['Saving']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
				$salesByUsers[$userID]['Advance']['value'] = $salesByUsers[$userID]['Payroll']['comission']*0.8;
			}
			if ($sale['Sale']['homeSecurity'] != 'None') 
			{
				$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['homeSecurity']]++;
				$comission = $this->Service->getPrice($sale['Sale']['homeSecurity'])*
					$this->Comission->getPerc($sale['User']['region'],$salesByUsers[$userID]['User']['topleader'],$salesByUsers[$userID]['User']['role_id'],$salesByUsers[$userID]['Total']['Qty'][$sale['Sale']['phone']]);
				$salesByUsers[$userID]['Total']['Val'][$sale['Sale']['homeSecurity']] += $comission; 
				$salesByUsers[$userID]['Total']['Qty']['XFINITY_HOME']++;
				$salesByUsers[$userID]['Total']['Val']['XFINITY_HOME'] += $comission;
				$salesByUsers[$userID]['Payroll']['comission'] += $comission;
				$salesByUsers[$userID]['Payroll']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
				$salesByUsers[$userID]['Payroll']['bonus'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['bonus'];
				$salesByUsers[$userID]['Saving']['saving'] = $salesByUsers[$userID]['Payroll']['comission'] * $salesByUsers[$userID]['User']['savingspercent'];
				$salesByUsers[$userID]['Advance']['value'] = $salesByUsers[$userID]['Payroll']['comission']*0.8;
			}

 		}

		$this->set('sales',$sales);
		$this->set('salesByUsers',$salesByUsers);
		$this->set('services',$services);

	}	

/**
 * new method
 *
 * @return void
 */
	public function newpayroll($receivableId) 
	{

		/*
		* Services array initialization
		*/
	    $tvServices = array(
	            'basic'=>'Basic TV',
	            'economytv'=>'Economy TV',
	            'starter'=>'Starter TV',
	            'preferred'=>'Preferred TV',
	            'premier'=>'Premier TV');
	    $netServices = array(
	            'economynet'=>'Economy Internet',
	            'performancenet'=>'Performance Internet',
	            'blastnet'=>'Blast Internet',
	            'extremenet'=>'Extreme Internet');
	    $phServices = array(
	            'localphone'=>'Local Phone',
	            'unlimitedphone'=>'Unlimited Phone');
	    $xhServices = array(
	            'xh300'=>'XH 300',
	            'xh350'=>'XH 350',
	            'xh100'=>'XH 100',
	            'xh150'=>'XH 150');
	    $xtServices = array(
	            'globo'=>'Globo',
	            'pfc'=>'PFC',
	            'record'=>'Record');

    	$this->loadModel('User');

		$this->loadModel('Sale');

		$this->loadModel('Saving');

		$this->loadModel('Comission');
		$comissionsByUser = $this->Comission->find('all', array(
			'conditions'=>array(
				'Comission.user_id'=>$this->objLoggedUser->getID()
				)));

		$this->loadModel('Receivable');
		$receivable = $this->Receivable->find('first', array(
			'conditions'=>array(
				'Receivable.id'=>$receivableId
				)
			)
		);

		foreach ($tvServices as $key => $value) {
			$arrTotTvSales[$key] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						'Sale.tv'=>$value
						))));
		}
		foreach ($netServices as $key => $value) {
			$arrTotNetSales[$key] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						'Sale.internet'=>$value
						))));
		}
		foreach ($phServices as $key => $value) {
			$arrTotPhSales[$key] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						'Sale.phone'=>$value
						))));
		}
		foreach ($xhServices as $key => $value) {
			$arrTotXhSales[$key] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						'Sale.homeSecurity'=>$value
						))));
		}
		foreach ($xtServices as $key => $value) {
			$arrTotXtSales[$key] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						"Sale.$key"=>true
						))));
		}
//		debug($arrTotXtSales);
		if ($this->objLoggedUser->getID() == '2')
		{
			$arrTotTvSalesByTopLeader['qtd'] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						'Sale.tv !='=>'None'
						))));
			$arrTotNetSalesByTopLeader['qtd'] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						'Sale.internet !='=>'None'
						))));
			$arrTotPhSalesByTopLeader['qtd'] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						'Sale.phone !='=>'None'
						))));
			$arrTotXhSalesByTopLeader['qtd'] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						'Sale.homeSecurity !='=>'None'
						))));
		}
		else
		{
			$arrTotTvSalesByTopLeader['qtd'] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						'Sale.tv !='=>'None',
						'User.topleader'=>$this->objLoggedUser->getID()
						))));
			$arrTotNetSalesByTopLeader['qtd'] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						'Sale.internet !='=>'None',
						'User.topleader'=>$this->objLoggedUser->getID()
						))));
			$arrTotPhSalesByTopLeader['qtd'] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						'Sale.phone !='=>'None',
						'User.topleader'=>$this->objLoggedUser->getID()
						))));
			$arrTotXhSalesByTopLeader['qtd'] = $this->Sale->find('count', array(
				'conditions'=>array(
					'AND'=>array(
						'Sale.comissioned'=> 0,
						'User.region'=>$receivable['Receivable']['region'],
						'Sale.sales_date >='=>$receivable['Receivable']['start'],
						'Sale.sales_date <='=>$receivable['Receivable']['end'],
						'Sale.homeSecurity !='=>'None',
						'User.topleader'=>$this->objLoggedUser->getID()
						))));
		}
		$arrTotTvSalesByTopLeader['val'] = 0;
		foreach ($tvServices as $key => $value) {
			$arrTotTvSalesByTopLeader['val'] += $receivable['Receivable'][$key];
		}

		$arrTotNetSalesByTopLeader['val'] = 0;
		foreach ($netServices as $key => $value) {
			$arrTotNetSalesByTopLeader['val'] += $receivable['Receivable'][$key];
		}

		$arrTotPhSalesByTopLeader['val'] = 0;
		foreach ($phServices as $key => $value) {
			$arrTotPhSalesByTopLeader['val'] += $receivable['Receivable'][$key];
		}

		$arrTotXhSalesByTopLeader['val'] = 0;
		foreach ($xhServices as $key => $value) {
			$arrTotXhSalesByTopLeader['val'] += $receivable['Receivable'][$key];
		}

		/*
		* Sales by User array initialization
		*/

		$salesByUsers = array();
		$childrenIds = Hash::extract($this->User->children($this->objLoggedUser->getID()), '{n}.User.id');
		foreach ($childrenIds as $key => $child) 
		{
			$objChild = $this->User->findById($child);

			if ($objChild->getAttr('region') == $receivable['Receivable']['region'])
			{
				$salesByUsers[$child]['Totals']['tv'] = 0;
				$salesByUsers[$child]['Totals']['net'] = 0;
				$salesByUsers[$child]['Totals']['ph'] = 0;
				$salesByUsers[$child]['Totals']['xh'] = 0;
				$salesByUsers[$child]['Totals']['xt'] = 0;
				$salesByUsers[$child]['Totals']['valtv'] = 0;
				$salesByUsers[$child]['Totals']['valnet'] = 0;
				$salesByUsers[$child]['Totals']['valph'] = 0;
				$salesByUsers[$child]['Totals']['valxh'] = 0;
				$salesByUsers[$child]['Totals']['valxt'] = 0;

				$salesByUsers[$child]['User'] = $objChild->data['User'];

				foreach ($tvServices as $keytv => $tv) 
				{
					if (!isset($salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keytv]['qtd']))
					{
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keytv]['qtd'] = 0;
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keytv]['val'] = 0;
					}
					if (!isset($salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keytv]['Fransh']['qtd']))
					{
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keytv]['Fransh']['qtd'] = $salesByUsers[$objChild->getAttr('topleader')]['Totals']['tv'] = 0;
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keytv]['Fransh']['val'] = 0;
					}

					$salesByUsers[$child]['Totals'][$keytv]['qtd'] = $objChild->Sale->getSalesByTV($objChild->getID(),$tv,$receivable['Receivable']['region'],$receivable['Receivable']['start'],$receivable['Receivable']['end']);

					$salesByUsers[$child]['Totals'][$keytv]['val'] = 0;

					$salesByUsers[$child]['Totals']['tv'] += $salesByUsers[$child]['Totals'][$keytv]['qtd'];

					if ( $salesByUsers[$child]['Totals'][$keytv]['qtd'] > 0 ) 
					{
						$salesByUsers[$child]['Totals'][$keytv]['val'] = ((($receivable['Receivable'][$keytv]/$arrTotTvSales[$keytv])*$this->Comission->getComissionPerc($this->objLoggedUser->getID(),$salesByUsers[$child]['User']['role_id'],$salesByUsers[$child]['Totals'][$keytv]['qtd']))*$salesByUsers[$child]['Totals'][$keytv]['qtd']);
						$salesByUsers[$child]['Totals']['valtv'] += $salesByUsers[$child]['Totals'][$keytv]['val'];

						if ($objChild->getAttr('role_id') != '4' && $objChild->getAttr('topleader') != $this->objLoggedUser->getID() )
						{
							$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keytv]['Fransh']['qtd'] += $salesByUsers[$child]['Totals'][$keytv]['qtd'];
							$salesByUsers[$objChild->getAttr('topleader')]['Totals']['tv'] += $salesByUsers[$child]['Totals'][$keytv]['qtd'];
							$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keytv]['Fransh']['val'] = ((($receivable['Receivable'][$keytv]/$arrTotTvSales[$keytv])*$this->Comission->getComissionPerc($this->objLoggedUser->getID(),'4',$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keytv]['Fransh']['qtd']))*$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keytv]['Fransh']['qtd']);
						}
					}
				}
				foreach ($netServices as $keynet => $net) 
				{
					if (!isset($salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keynet]['qtd']))
					{
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keynet]['qtd'] = 0;
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keynet]['val'] = 0;
					}
					if (!isset($salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keynet]['Fransh']['qtd']))
					{
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keynet]['Fransh']['qtd'] = $salesByUsers[$objChild->getAttr('topleader')]['Totals']['net'] = 0;
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keynet]['Fransh']['val'] = 0;
					}

					$salesByUsers[$child]['Totals'][$keynet]['qtd'] = $objChild->Sale->getSalesByNet($objChild->getID(),$net,$receivable['Receivable']['region'],$receivable['Receivable']['start'],$receivable['Receivable']['end']);

					$salesByUsers[$child]['Totals'][$keynet]['val'] = 0;

					$salesByUsers[$child]['Totals']['net'] += $salesByUsers[$child]['Totals'][$keynet]['qtd'];

					if ( $salesByUsers[$child]['Totals'][$keynet]['qtd'] > 0 ) 
					{
						$salesByUsers[$child]['Totals'][$keynet]['val'] = ((($receivable['Receivable'][$keynet]/$arrTotNetSales[$keynet])*$this->Comission->getComissionPerc($this->objLoggedUser->getID(),$salesByUsers[$child]['User']['role_id'],$salesByUsers[$child]['Totals'][$keynet]['qtd']))*$salesByUsers[$child]['Totals'][$keynet]['qtd']);
						$salesByUsers[$child]['Totals']['valnet'] += $salesByUsers[$child]['Totals'][$keynet]['val'];

						if ($objChild->getAttr('role_id') != '4' && $objChild->getAttr('topleader') != $this->objLoggedUser->getID() )
						{
							$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keynet]['Fransh']['qtd'] += $salesByUsers[$child]['Totals'][$keynet]['qtd'];
							$salesByUsers[$objChild->getAttr('topleader')]['Totals']['net'] += $salesByUsers[$child]['Totals'][$keynet]['qtd'];
							$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keynet]['Fransh']['val'] = ((($receivable['Receivable'][$keynet]/$arrTotNetSales[$keynet])*$this->Comission->getComissionPerc($this->objLoggedUser->getID(),'4',$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keynet]['Fransh']['qtd']))*$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keynet]['Fransh']['qtd']);
						}
					}
				}
				foreach ($phServices as $keyph => $ph) 
				{
					if (!isset($salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyph]['qtd']))
					{
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyph]['qtd'] = 0;
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyph]['val'] = 0;
					}
					if (!isset($salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyph]['Fransh']['qtd']))
					{
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyph]['Fransh']['qtd'] = $salesByUsers[$objChild->getAttr('topleader')]['Totals']['ph'] = 0;
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyph]['Fransh']['val'] = 0;
					}

					$salesByUsers[$child]['Totals'][$keyph]['qtd'] = $objChild->Sale->getSalesByPh($objChild->getID(),$ph,$receivable['Receivable']['region'],$receivable['Receivable']['start'],$receivable['Receivable']['end']);

					$salesByUsers[$child]['Totals'][$keyph]['val'] = 0;

					$salesByUsers[$child]['Totals']['ph'] += $salesByUsers[$child]['Totals'][$keyph]['qtd'];

					if ( $salesByUsers[$child]['Totals'][$keyph]['qtd'] > 0 ) 
					{
						$salesByUsers[$child]['Totals'][$keyph]['val'] = ((($receivable['Receivable'][$keyph]/$arrTotPhSales[$keyph])*$this->Comission->getComissionPerc($this->objLoggedUser->getID(),$salesByUsers[$child]['User']['role_id'],$salesByUsers[$child]['Totals'][$keyph]['qtd']))*$salesByUsers[$child]['Totals'][$keyph]['qtd']);
						$salesByUsers[$child]['Totals']['valph'] += $salesByUsers[$child]['Totals'][$keyph]['val'];

						if ($objChild->getAttr('role_id') != '4' && $objChild->getAttr('topleader') != $this->objLoggedUser->getID() )
						{
							$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyph]['Fransh']['qtd'] += $salesByUsers[$child]['Totals'][$keyph]['qtd'];
							$salesByUsers[$objChild->getAttr('topleader')]['Totals']['ph'] += $salesByUsers[$child]['Totals'][$keyph]['qtd'];
							$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyph]['Fransh']['val'] = ((($receivable['Receivable'][$keyph]/$arrTotPhSales[$keyph])*$this->Comission->getComissionPerc($this->objLoggedUser->getID(),'4',$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyph]['Fransh']['qtd']))*$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyph]['Fransh']['qtd']);
						}
					}
				}
				foreach ($xhServices as $keyxh => $xh) 
				{
					if (!isset($salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyxh]['qtd']))
					{
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyxh]['qtd'] = 0;
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyxh]['val'] = 0;
					}
					if (!isset($salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyxh]['Fransh']['qtd']))
					{
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyxh]['Fransh']['qtd'] = $salesByUsers[$objChild->getAttr('topleader')]['Totals']['xh'] = 0;
						$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyxh]['Fransh']['val'] = 0;
					}

					$salesByUsers[$child]['Totals'][$keyxh]['qtd'] = $objChild->Sale->getSalesByXh($objChild->getID(),$xh,$receivable['Receivable']['region'],$receivable['Receivable']['start'],$receivable['Receivable']['end']);

					$salesByUsers[$child]['Totals'][$keyxh]['val'] = 0;

					$salesByUsers[$child]['Totals']['xh'] += $salesByUsers[$child]['Totals'][$keyxh]['qtd'];

					if ( $salesByUsers[$child]['Totals'][$keyxh]['qtd'] > 0 ) 
					{
						$salesByUsers[$child]['Totals'][$keyxh]['val'] = ((($receivable['Receivable'][$keyxh]/$arrTotXhSales[$keyxh])*$this->Comission->getComissionPerc($this->objLoggedUser->getID(),$salesByUsers[$child]['User']['role_id'],$salesByUsers[$child]['Totals'][$keyxh]['qtd']))*$salesByUsers[$child]['Totals'][$keyxh]['qtd']);
						$salesByUsers[$child]['Totals']['valxh'] += $salesByUsers[$child]['Totals'][$keyxh]['val'];

						if ($objChild->getAttr('role_id') != '4' && $objChild->getAttr('topleader') != $this->objLoggedUser->getID() )
						{
							$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyxh]['Fransh']['qtd'] += $salesByUsers[$child]['Totals'][$keyxh]['qtd'];
							$salesByUsers[$objChild->getAttr('topleader')]['Totals']['xh'] += $salesByUsers[$child]['Totals'][$keyxh]['qtd'];
							$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyxh]['Fransh']['val'] = ((($receivable['Receivable'][$keyxh]/$arrTotXhSales[$keyxh])*$this->Comission->getComissionPerc($this->objLoggedUser->getID(),'4',$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyxh]['Fransh']['qtd']))*$salesByUsers[$objChild->getAttr('topleader')]['Totals'][$keyxh]['Fransh']['qtd']);
						}
					}
				}
				$salesByUsers[$child]['Sales'] = $objChild->Sale->getSalesByRange($objChild->getID(),$receivable['Receivable']['region'],$receivable['Receivable']['start'],$receivable['Receivable']['end']);
				$salesByUsers[$child]['Sale'] = $objChild->Sale->getSalesByDay($objChild->getID(),$receivable['Receivable']['region'],$receivable['Receivable']['start'],$receivable['Receivable']['end']);
			}
		}
		foreach ($salesByUsers as $key => $sale) {
			if ($key != $this->objLoggedUser->getID())
			{
				if ($sale['User']['role_id'] == '4')
				{
					foreach ($tvServices as $keytv => $value) {
						if (isset($sale['Totals'][$keytv]['Fransh']['val']))
						{
							$salesByUsers[$key]['Totals']['valtv'] += $sale['Totals'][$keytv]['Fransh']['val'];
						}
					}
					foreach ($netServices as $keynet => $value) {
						if (isset($sale['Totals'][$keynet]['Fransh']['val']))
						{
							$salesByUsers[$key]['Totals']['valnet'] += $sale['Totals'][$keynet]['Fransh']['val'];
						}
					}
					foreach ($phServices as $keyph => $value) {
						if (isset($sale['Totals'][$keyph]['Fransh']['val']))
						{
							$salesByUsers[$key]['Totals']['valph'] += $sale['Totals'][$keyph]['Fransh']['val'];
						}
					}
					foreach ($xhServices as $keyxh => $value) {
						if (isset($sale['Totals'][$keyxh]['Fransh']['val']))
						{
							$salesByUsers[$key]['Totals']['valxh'] += $sale['Totals'][$keyxh]['Fransh']['val'];
						}
					}
					$salesByUsers[$key]['start'] = $receivable['Receivable']['start'];
					$salesByUsers[$key]['end'] = $receivable['Receivable']['end'];
					$salesByUsers[$key]['recdate'] = $receivable['Receivable']['recdate'];
					$salesByUsers[$key]['user_id'] = $key;

				}
				$salesByUsers[$key]['Total'] = $salesByUsers[$key]['Totals']['valtv']+$salesByUsers[$key]['Totals']['valnet']+$salesByUsers[$key]['Totals']['valph']+$salesByUsers[$key]['Totals']['valxh'];
				$salesByUsers[$key]['Bonus'] = $salesByUsers[$key]['Total'] * $salesByUsers[$key]['User']['bonus'];
				$salesByUsers[$key]['Savings'] = $salesByUsers[$key]['Total'] * $salesByUsers[$key]['User']['savingspercent'];
				$salesByUsers[$key]['Due'] = $salesByUsers[$key]['Total'] + $salesByUsers[$key]['Bonus']-$salesByUsers[$key]['Savings'];
				$salesByUsers[$key]['Payroll']['user_id'] = $key;
				$salesByUsers[$key]['Payroll']['receivable_id'] = $receivable['Receivable']['id'];
				$salesByUsers[$key]['Payroll']['payrolldate'] = date('Y-m-d');
				$salesByUsers[$key]['Payroll']['comission'] = $salesByUsers[$key]['Total'] + $salesByUsers[$key]['Bonus']-$salesByUsers[$key]['Savings'];
				$salesByUsers[$key]['Saving']['user_id'] = $key;
				$salesByUsers[$key]['Saving']['savingdate'] = date('Y-m-d');
				$salesByUsers[$key]['Saving']['receivable_id'] = $receivable['Receivable']['id'];
				$salesByUsers[$key]['Saving']['saving'] = $salesByUsers[$key]['Savings'];
				$balance = $this->Saving->query("SELECT SUM(saving) AS balance FROM savings WHERE `user_id` = '$key'");
				$salesByUsers[$key]['Saving']['balance'] = $salesByUsers[$key]['Savings']+$balance[0][0]['balance'];
			}
		}

//		debug($salesByUsers);

		$this->set('salesByUsers', $salesByUsers);

		$this->set('comissionsByUser', $comissionsByUser);

		$this->set('receivable',$receivable);
		$this->set('arrTotTvSales',$arrTotTvSales);
		$this->set('arrTotNetSales',$arrTotNetSales);
		$this->set('arrTotPhSales',$arrTotPhSales);
		$this->set('arrTotXhSales',$arrTotXhSales);
		$this->set('arrTotTvSalesByTopLeader',$arrTotTvSalesByTopLeader);
		$this->set('arrTotNetSalesByTopLeader',$arrTotNetSalesByTopLeader);
		$this->set('arrTotPhSalesByTopLeader',$arrTotPhSalesByTopLeader);
		$this->set('arrTotXhSalesByTopLeader',$arrTotXhSalesByTopLeader);
		$this->set(compact('receivables','tvServices','netServices','phServices','xhServices','xtServices'));

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
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Payroll->create();
			if ($this->Payroll->save($this->request->data)) {
				$this->Session->setFlash(__('The payroll has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The payroll could not be saved. Please, try again.'));
			}
		}
		$users = $this->Payroll->User->find('list');
		$this->set(compact('users'));
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
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Payroll->id = $id;
		if (!$this->Payroll->exists()) {
			throw new NotFoundException(__('Invalid payroll'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Payroll->delete()) {
			$this->Session->setFlash(__('The payroll has been deleted.'));
		} else {
			$this->Session->setFlash(__('The payroll could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function generate()
	{
		$this->loadModel('User');
		$this->loadModel('Sale');
		$this->loadModel('Saving');
		$this->loadModel('Receivable');
		$this->autoRender = false;
		foreach ($this->data as $key => $userInfo) 
		{
			$this->Payroll->save($userInfo['Payroll']);
			$this->Payroll->id = null;
			$this->Saving->save($userInfo['Saving']);
			$this->Saving->id = null;
			if ($userInfo['User']['role_id'] == '4')
			{
				$data['Receivable']['id'] = null;
				$data['Receivable']['user_id'] = $userInfo['User']['id'];
				$data['Receivable']['region'] = $userInfo['User']['region'];
				$data['Receivable']['start'] = $userInfo['start'];
				$data['Receivable']['end'] = $userInfo['end'];
				$data['Receivable']['recdate'] = $userInfo['recdate'];
				$data['Receivable']['basic'] = $userInfo['Totals']['basic']['Fransh']['val'];
				$data['Receivable']['economytv'] = $userInfo['Totals']['economytv']['Fransh']['val'];
				$data['Receivable']['starter'] = $userInfo['Totals']['starter']['Fransh']['val'];
				$data['Receivable']['preferred'] = $userInfo['Totals']['preferred']['Fransh']['val'];
				$data['Receivable']['premier'] = $userInfo['Totals']['premier']['Fransh']['val'];
				$data['Receivable']['economynet'] = $userInfo['Totals']['economynet']['Fransh']['val'];
				$data['Receivable']['performancenet'] = $userInfo['Totals']['performancenet']['Fransh']['val'];
				$data['Receivable']['blastnet'] = $userInfo['Totals']['blastnet']['Fransh']['val'];
				$data['Receivable']['extremenet'] = $userInfo['Totals']['extremenet']['Fransh']['val'];
				$data['Receivable']['localphone'] = $userInfo['Totals']['localphone']['Fransh']['val'];
				$data['Receivable']['unlimitedphone'] = $userInfo['Totals']['unlimitedphone']['Fransh']['val'];
				$data['Receivable']['xh300'] = $userInfo['Totals']['xh300']['Fransh']['val'];
				$data['Receivable']['xh350'] = $userInfo['Totals']['xh350']['Fransh']['val'];
				$data['Receivable']['xh100'] = $userInfo['Totals']['xh100']['Fransh']['val'];
				$data['Receivable']['xh150'] = $userInfo['Totals']['xh150']['Fransh']['val'];
				$data['Receivable']['processdate'] = $today;
				$this->Receivable->save($data['Receivable']);
			}
			foreach ($userInfo['Sale'] as $key1 => $sale) 
			{
				$this->Sale->id = $sale['id'];
				$this->Sale->savefield('comissioned',1);
			}
		}
		echo '<pre>'.print_r($this->data,true).'</pre>';
		exit;
	}
}
