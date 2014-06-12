<?php
App::uses('AppModel', 'Model');
/**
 * Sale Model
 *
 * @property User $User
 * @property Customer $Customer
 * @property Service $Service
 */
class Sale extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function beforeSave()
	{
		if (isset($this->data['Sale']['instalation']))
		{
			$this->data['Sale']['instalation'] = date('Y-m-d', strtotime($this->data['Sale']['instalation']));
		}
		if (isset($this->data['Sale']['sales_date']))
		{
			$this->data['Sale']['sales_date'] = date('Y-m-d', strtotime($this->data['Sale']['sales_date']));
		}
	}

	public function afterSave($created) {

		$arrDateFactors = array('0','2','15','60');
		$arrTtile = array('VOID','Greetings ','Follow Up (15 days) - ','60 days Follow Up - ');
		if ($created)
		{
			$this->loadModel('Event');

			for ($i=1;$i<4;$i++) {
				$this->Event->create();
				$this->data['Event']['user_id'] = $this->data['Sale']['user_id'];
				$this->data['Event']['sales_id'] = $this->data['Sale']['id'];
				$this->data['Event']['event_type_id'] = $i;
				$this->data['Event']['title'] = $arrTtile[$i].$this->data['Customer']['name'];
				$this->data['Event']['details'] = 'Call '.$this->data['Customer']['cellphone'].' / '.$this->data['Customer']['workphone']. ' or send an email to '.$this->data['Customer']['email'];
				$this->data['Event']['start'] = date('Y-m-d',strtotime('+'.$arrDateFactors[$i].' day',strtotime($this->data['Sale']['instalation']))).' 10:00:00';
				$this->data['Event']['end'] = date('Y-m-d',strtotime('+'.$arrDateFactors[$i].' day',strtotime($this->data['Sale']['instalation']))).' 10:30:00';
				$this->Event->save($this->data);
			}
		}
		else
		{
			if (isset($this->data['Sale']['instalation']))
			{
				$this->loadModel('Event');
				$events = $this->Event->find('all', array('conditions'=>array('Event.sale_id'=>$this->data['Sale']['id'])));
				foreach ($events as $key => $event) 
				{
					$this->Event->id = $event['Event']['id'];
					switch ($event['Event']['event_type_id']) {
						case '1':
							$this->Event->saveField('start', date('Y-m-d',strtotime('+'.$arrDateFactors[1].' day',strtotime($this->data['Sale']['instalation']))).' 10:00:00');
							$this->Event->saveField('end',date('Y-m-d',strtotime('+'.$arrDateFactors[1].' day',strtotime($this->data['Sale']['instalation']))).' 10:30:00');
							break;
						case '2':
							$this->Event->saveField('start', date('Y-m-d',strtotime('+'.$arrDateFactors[2].' day',strtotime($this->data['Sale']['instalation']))).' 10:00:00');
							$this->Event->saveField('end',date('Y-m-d',strtotime('+'.$arrDateFactors[2].' day',strtotime($this->data['Sale']['instalation']))).' 10:30:00');
							break;
						case '3':
							$this->Event->saveField('start',date('Y-m-d',strtotime('+'.$arrDateFactors[3].' day',strtotime($this->data['Sale']['instalation']))).' 10:00:00');
							$this->Event->saveField('end',date('Y-m-d',strtotime('+'.$arrDateFactors[3].' day',strtotime($this->data['Sale']['instalation']))).' 10:30:00');
							break;
					}
				}
			}
		}
	}

	public function getSalesByRange($id,$region,$start,$end)
	{
		return $this->find('all', array(
				'fields'=>'DISTINCT DAY(Sale.sales_date) AS day, COUNT(DAY(Sale.sales_date)) AS total',
				'group'=>'DAY(Sale.sales_date)',
				'conditions'=> array(
					'AND'=> array(
						'Sale.user_id'=>$id,
						'Sale.comissioned'=>false,
						'User.region'=>$region,
						'Sale.sales_date >='=>$start,
						'Sale.sales_date <='=>$end
						))));		
	}

	public function getSalesByDay($id,$region,$start,$end)
	{
		return $this->find('all', array(
				'fields'=>'Sale.id, Sale.user_id',
				'conditions'=> array(
					'AND'=> array(
						'Sale.user_id'=>$id,
						'Sale.comissioned'=>false,
						'User.region'=>$region,
						'Sale.sales_date >='=>$start,
						'Sale.sales_date <='=>$end
						)),
				'order'=>'DAY(Sale.sales_date)'
				));		
	}

	public function getMonthlySales($id)
	{
		return $this->find('all', array(
				'fields'=>'DISTINCT DAY(Sale.sales_date) AS day, COUNT(DAY(Sale.sales_date)) AS total',
				'group'=>'DAY(Sale.sales_date)',
				'conditions'=> array(
					'AND'=> array(
						'Sale.user_id'=>$id,
						'MONTH(Sale.sales_date)'=> date('m')
						))));		
	}

	public function getSalesByTV($id,$serv,$region,$start,$end)
	{
		return $this->find('count', array(
					'conditions'=>array(
						'AND'=>array(
							'Sale.comissioned'=> 0,
							'Sale.tv'=>$serv,
							'Sale.user_id'=>$id,
							'Sale.comissioned'=>false,
							'User.region'=>$region,
							'Sale.sales_date >='=>$start,
							'Sale.sales_date <='=>$end
							))));
	}

	public function getSalesByNet($id,$serv,$region,$start,$end)
	{
		return $this->find('count', array(
					'conditions'=>array(
						'AND'=>array(
							'Sale.comissioned'=> 0,
							'Sale.internet'=>$serv,
							'Sale.user_id'=>$id,
							'Sale.comissioned'=>false,
							'User.region'=>$region,
							'Sale.sales_date >='=>$start,
							'Sale.sales_date <='=>$end
							))));
	}

	public function getSalesByPh($id,$serv,$region,$start,$end)
	{
		return $this->find('count', array(
					'conditions'=>array(
						'AND'=>array(
							'Sale.comissioned'=> 0,
							'Sale.phone'=>$serv,
							'Sale.user_id'=>$id,
							'Sale.comissioned'=>false,
							'User.region'=>$region,
							'Sale.sales_date >='=>$start,
							'Sale.sales_date <='=>$end
							))));
	}

	public function getSalesByXh($id,$serv,$region,$start,$end)
	{
		return $this->find('count', array(
					'conditions'=>array(
						'AND'=>array(
							'Sale.comissioned'=> 0,
							'Sale.homeSecurity'=>$serv,
							'Sale.user_id'=>$id,
							'Sale.comissioned'=>false,
							'User.region'=>$region,
							'Sale.sales_date >='=>$start,
							'Sale.sales_date <='=>$end
							))));
	}
	
}
