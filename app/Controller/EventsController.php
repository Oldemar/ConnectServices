<?php
App::uses('CakeTime', 'Utility');

/*
 * Controller/EventsController.php
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */

class EventsController extends AppController {

	var $name = 'Events';
	
	public $helper = array('Js');
	public $component =  array('RequestHandler');

    var $paginate = array(
        'limit' => 15
    );

    function index() {
		$this->Event->recursive = 1;
		$this->set('events', $this->paginate());
	}


    function dairyAgenda($date) {
    	$this->loadModel('User');
		$childrenIds = Hash::extract($this->User->children($this->objLoggedUser->getID(),true), '{n}.User.id');
		$childrenIds[] = $this->Auth->User('id');
    	$eventByUser = $this->Event->User->find('all', array(
    		'conditions'=> array(
    			'User.id'=>$childrenIds
    			)
    		)
    	);
    	$events = $this->Event->find('all', array(
    		'conditions'=> array(
    			"STR_TO_DATE(`Event.start`,'%Y-%m-%d')"=>$date,
    		),
    		'order'=>array(
    			'Event.start'=>'asc')
    		)
    	);
		$this->Event->recursive = 1;
		$this->set('events', $events);
		$this->set('eventByUser',$eventByUser);
		$this->set('users',$this->Event->User->find('list',array('conditions'=>array('User.role_id'=>'3'))));
		$this->set('eventTypes',$this->Event->EventType->find('list'));
		$this->set('users',$this->Event->User->find('list',array('conditions'=>array('User.id'=>$childrenIds))));
		$this->set('eventDate', $date);
	}

    function weeklyAgenda($date) {

    	$date = date('Y-m-d', strtotime('last monday', strtotime($date."+1 day")));
     	$this->loadModel('User');
     	if (!in_array($this->objLoggedUser->getAttr('role_id'), array('6', '7')))
     	{
     		if ($this->objLoggedUser->getAttr('role_id') == '9') {
	     		$userIds =  Hash::extract($this->User->children($this->objLoggedUser->getAttr('topleader')), '{n}.User.id');
	     		$userIds[] = $this->objLoggedUser->getID();
     		}
     		else
     		{
	     		$userIds =  Hash::extract($this->User->children($this->objLoggedUser->getID()), '{n}.User.id');
	     		$userIds[] = $this->objLoggedUser->getID();
     		}
     	}
     	else
     	{
     		$userIds = $this->objLoggedUser->getID();
     	}

    	$eventsByDay = array();

   		for ($t=16;$t<45;$t++)
    	{
    		for ($i=0;$i<7;$i++)
     		{
		 		$eventsByDay[$t][$i] = $this->Event->find('all', array(
						'conditions'=> array(
							'Event.user_id'=>$userIds,
							'Event.start '=>date('Y-m-d H:i:s',strtotime($date . "+$i days".gmdate('h:i a', $t*1800))))
							)
						);
    		}
     	}

   		$eventsByDay1 = array();

    	for ($i=0;$i<7;$i++)
     	{
  			for ($t=16;$t<45;$t++)
     		{
		 		$eventsByDay1[$i][$t] = $this->Event->find('all', array(
						'conditions'=> array(
							'Event.user_id'=>$userIds,
							'Event.start '=>date('Y-m-d H:i:s',strtotime($date . "+$i days".gmdate('h:i a', $t*1800))))
							)
						);
    		}
     	}


		$this->set('eventsByDay1',$eventsByDay1);
		$this->set('eventsByDay',$eventsByDay);
		$this->set('userIds',$userIds);
		$this->set('date',$date);
	}

	function dairyAgendaNew($date) {
     	$this->loadModel('User');
     	if (!in_array($this->objLoggedUser->getAttr('role_id'), array('6', '7')))
     	{
     		if ($this->objLoggedUser->getAttr('role_id') == '9') {
	     		$userIds =  Hash::extract($this->User->children($this->objLoggedUser->getAttr('topleader')), '{n}.User.id');
	     		$userIds[] = $this->objLoggedUser->getID();
     		}
     		else
     		{
	     		$userIds =  Hash::extract($this->User->children($this->objLoggedUser->getID()), '{n}.User.id');
	     		$userIds[] = $this->objLoggedUser->getID();
     		}
     	}
     	else
     	{
     		$userIds = $this->objLoggedUser->getID();
     	}

    	$eventsByDay = array();

   		for ($t=16;$t<45;$t++)
    	{
	 		$eventsByDay[$t] = $this->Event->find('all', array(
					'conditions'=> array(
						'Event.user_id'=>$userIds,
						'Event.start '=>date('Y-m-d H:i:s',strtotime($date.gmdate('h:i a', $t*1800))))
						)
					);
     	}

   		$eventsByDay1 = array();

    	for ($i=0;$i<7;$i++)
     	{
  			for ($t=16;$t<45;$t++)
     		{
		 		$eventsByDay1[$i][$t] = $this->Event->find('all', array(
						'conditions'=> array(
							'Event.user_id'=>$userIds,
							'Event.start '=>date('Y-m-d H:i:s',strtotime($date . "+$i days".gmdate('h:i a', $t*1800))))
							)
						);
    		}
     	}

		$this->set('eventTypes', $this->Event->EventType->find('list'));
     	
		$this->set('eventsByDay1',$eventsByDay1);
		$this->set('eventsByDay',$eventsByDay);
		$this->set('userIds',$userIds);
		$this->set('date',$date);
	}

	function monthlyAgenda() {
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid event', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('event', $this->Event->read(null, $id));
	}

	function add() {

		if (!empty($this->data)) {
			$this->Event->create();
			if ($this->Event->save($this->data)) {
				$this->Session->setFlash(__('The event has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.', true));
			}
		}
		$this->set('eventTypes', $this->Event->EventType->find('list'));
		$this->set('users', $this->Event->User->find('list', array(
			'conditions'=> array('User.role_id'=>'3'))));
	}

	function edit($id = null) {
		if (!empty($this->data)) {
			if ($this->Event->save($this->data)) {
				$this->Session->setFlash(__('The event has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Event->read(null, $id);
		}
		$this->set('eventTypes', $this->Event->EventType->find('list'));
		$this->set('users', $this->Event->User->find('list', array(
			'conditions'=> array('User.role_id'=>'3'))));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for event', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Event->delete($id)) {
			$this->Session->setFlash(__('Event deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Event was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

        // The feed action is called from "webroot/js/ready.js" to get the list of events (JSON)
	function feed($id=null) {
		$this->layout = "ajax";
		$vars = $this->params['url'];
		$conditions = array('conditions' => array('UNIX_TIMESTAMP(start) >=' => $vars['start'], 'UNIX_TIMESTAMP(start) <=' => $vars['end']));
		$events = $this->Event->find('all', $conditions);
		foreach($events as $event) {
			if($event['Event']['all_day'] == 1) {
				$allday = true;
				$end = $event['Event']['start'];
			} else {
				$allday = false;
				$end = $event['Event']['end'];
			}
			$data[] = array(
					'id' => $event['Event']['id'],
					'title'=>$event['Event']['title'],
					'start'=>$event['Event']['start'],
					'username'=>$event['User']['username'],
					'end' => $end,
					'allDay' => $allday,
					'url' => Router::url('/') . 'full_calendar/events/view/'.$event['Event']['id'],
					'details' => $event['Event']['details'],
					'className' => $event['EventType']['color']
			);
		}
		$this->set("json", json_encode($data));
	}

	function update() {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->Event->id = $this->data['id'];
		$this->Event->saveField('user_id', $this->data['user']);
		$this->Event->saveField('start', date('Y-m-d H:i:s', strtotime($this->data['start'])));
		if (isset($this->data['end']))
		{
			$end = $this->data['end']*30;
			$eventEnd = new DateTime($this->data['start']);
			$eventEnd->add(new DateInterval('PT'.$end.'M'));
		}
		else
		{
			$eventEnd = new DateTime($this->data['start']);
			$eventEnd->add(new DateInterval('PT30M'));
		}
		$this->Event->saveField('end', $eventEnd->format('Y-m-d H:i:s'));
		return $this->data['start'].' - '.$eventEnd->format('Y-m-d H:i:s').' - '.$end;
	}

	function updatest() {
		$this->autoRender = false;
		$this->layout = 'ajax';
		return $this->data['Event'];
	}

	function resize() {
		$this->autoRender = false;
		$this->layout = 'ajax';
		$this->Event->id = $this->data['id'];
		$this->Event->saveField('user_id', $this->data['user']);
		$end = $this->data['startTime']*30+$this->data['end']*30;
		$eventEnd = new DateTime($this->data['start']);
		$eventEnd->add(new DateInterval('PT'.$end.'M'));
		$this->Event->saveField('end', $eventEnd->format('Y-m-d H:i:s'));
		return $eventEnd->format('Y-m-d H:i:s').' - '.$end;
	}
	public function addAjax(){
		if (empty($this->data)) {
			$this->data = $this->Event->read(null, $id);
		}
		$this->set('eventTypes', $this->Event->EventType->find('list'));
		$this->set('users', $this->Event->User->find('list', array(
			'conditions'=> array('User.role_id'=>'3'))));
		echo $this->element('Events/eventForm');
		exit();
	}
	
	public function editAjax($id){
		if (empty($this->data)) {
			$this->data = $this->Event->read(null, $id);
		}
		$this->set('eventTypes', $this->Event->EventType->find('list'));
		$this->set('users', $this->Event->User->find('list', array(
			'conditions'=> array('User.role_id'=>'3'))));
		echo $this->element('Events/eventForm');
		exit();
	}
	


}
?>
