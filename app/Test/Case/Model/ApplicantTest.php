<?php
App::uses('Applicant', 'Model');

/**
 * Applicant Test Case
 *
 */
class ApplicantTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.applicant',
		'app.user',
		'app.role',
		'app.region',
		'app.sale',
		'app.customer',
		'app.carrier',
		'app.service',
		'app.event',
		'app.event_type',
		'app.payroll',
		'app.saving',
		'app.advance'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Applicant = ClassRegistry::init('Applicant');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Applicant);

		parent::tearDown();
	}

}
