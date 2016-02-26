<?php
App::uses('AppController', 'Controller');
/**
 * Sales Controller
 *
 * @property Sale $Sale
 * @property PaginatorComponent $Paginator
 */
class GraphicsController extends AppController {

/**
 * Components
 *
 * @var array
 */


	public $arrMonth =  array(
			"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
			);



/**
 * index method
 *
 * @return void
 */
	public function index() {

	}

/**
 * getsales method
 *
 * @return void
 */
	public function getsales() {

		$this->autRender = false;
		$this->loadModel('Sale');
		$id = null;
		if (!$this->isAuthorized()) {
			$id = array('Sale.user_id'=>$this->objLoggedUser->getID());
		}
		$arrNotComiss = $this->Sale->find('all', array(
				'fields'=>'DISTINCT MONTH(Sale.sales_date) AS month, COUNT(MONTH(Sale.sales_date)) AS total',
				'group'=>'MONTH(Sale.sales_date)',
				'conditions'=> array(
					'Sale.comissioned'=>false, $id
					)));
		$arrComiss = $this->Sale->find('all', array(
				'fields'=>'DISTINCT MONTH(Sale.sales_date) AS month, COUNT(MONTH(Sale.sales_date)) AS total',
				'group'=>'MONTH(Sale.sales_date)',
				'conditions'=> array(
					'Sale.comissioned'=>true, $id
					)));
		$arrCharged = $this->Sale->find('all', array(
				'fields'=>'DISTINCT MONTH(Sale.sales_date) AS month, COUNT(MONTH(Sale.sales_date)) AS total',
				'group'=>'MONTH(Sale.sales_date)',
				'conditions'=> array(
					'Sale.chargeback'=>true, $id
					)));
		$arrCatNames = array();

		$arrMonth =  array(
			"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
			);

		$arrReturn = array(
				array('name'=>'Not Comissioned','data'=>array(0,0,0,0,0,0)),
				array('name'=>'Comissioned','data'=>array(0,0,0,0,0,0)),
				array('name'=>'Charged Back','data'=>array(0,0,0,0,0,0))
			);

		$i0 = $startMonth = date('n') > 6 ? date('n') - 6 : 12 - (6 - date('n'));

		for ($i=0; $i < 6; $i++) {
			
			$i0 = $i0 > 11 ? 0 : $i0;
			$arrCatNames[] = $arrMonth[$i0];
			foreach ($arrNotComiss as $key0 => $rows0) {
				if ((int)$rows0[0]['month'] == (int)$i0 + 1) {
					$arrReturn[0]['data'][$i] = (int)$rows0[0]['total'];
					break;
				}
			}
			foreach ($arrComiss as $key1 => $rows1) {
				if ((int)$rows1[0]['month'] == (int)$i0 + 1) {
					$arrReturn[1]['data'][$i] = (int)$rows1[0]['total'];
					break;
				}
			}
			foreach ($arrCharged as $key2 => $rows2) {
				if ((int)$rows2[0]['month'] == (int)$i0 + 1) {
					$arrReturn[2]['data'][$i] = (int)$rows2[0]['total'];
					break;
				}
			}
			$i0++;

		}
//		echo '<pre>'.print_r($arrNotComiss,true).'</pre>';

		$arrReturn['Start Month'] = $startMonth;
		$arrReturn['arrCat'] = $arrCatNames;
		echo json_encode($arrReturn);

		exit;		
	}

/**
 * getsales by region method
 *
 * @return void
 */
	public function getsalesbyregion() {

		$this->autRender = false;
		$this->loadModel('Sale');
		$this->loadModel('Region');
		$regions = $this->Region->find('list');
		$arrSeries = array();
		foreach ($regions as $key => $region) {
			$arrTotals = array();
			$arrSales = $this->Sale->find('all', array(
					'fields'=>'DISTINCT MONTH(Sale.sales_date) AS month, COUNT(MONTH(Sale.sales_date)) AS total',
					'group'=>'MONTH(Sale.sales_date)',
					'conditions'=> array(
						'Sale.region_id'=>$key
						)));
			foreach ($arrSales as $keyTemp => $total) {
				$arrTotals[] = (int)$total[0]['total'];
			}
			$arrSeries[] = array('name' => $regions[$key],'data' => $arrTotals);
		}

//		echo '<pre>'.print_r($regions,true).'</pre>';
//		echo '<pre>'.print_r($arrSales,true).'</pre>';

//		$arrReturn['arrCat'] = $arrCatNames;
		$arrReturn['series'] = $arrSeries;
		echo json_encode($arrReturn);

		exit;		
	}


}