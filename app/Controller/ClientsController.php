<?php
App::uses('AppController', 'Controller');

class ClientsController extends AppController {

	public $name = 'Clients';
	public $uses = array('Image','Clinic','Vet','VetImage','Category','AppointmentType');
	public $helpers = array('Calendar');
  
	public function beforeFilter() {
		parent::beforeFilter();
		## defined global layout for whole controller.
		$this->layout = 'homepage';
	}
  
	/**
	*Summary of Method: Homepage of the site.
	*created by: 1497
	*date:  01-02-16
	* */
	public function index() {
		//Configure::write('debug', 2);
		
		$this->set('site_title', 'Welcome');
		$this->set('types', $this->Category->getType());
		$this->set('appointment_types',$this->AppointmentType->find('list',array('fields'=>array('id','name'))));
		$account = !empty($this->request->query['account'])? $this->request->query['account'] : '';
		$type = !empty($this->request->query['type'])? $this->request->query['type'] : '';
		$token = !empty($this->request->query['token'])? $this->request->query['token'] : '';
		$set_password = array();
		if( $account && $type && $token ){
			if($this->Vet->hasAny(array('Vet.token' => trim($token)))){
				$vet = $this->Vet->findByToken(trim($token));
				if($vet['Vet']['credential_send'] == 1){
					$data = array( 
						'account' 	=> $account,
						'type'		=> $type,
						'token'		=> trim($token),
						'id'		=> base64_encode($vet['Vet']['id']),
						'name'		=> $vet['Vet']['name']
					);
					$set_password = array('success' => $data);
				} else {
					$set_password = array('error' => 'Account already activated. Kindly login.');
				}
			} else {
				$set_password = array('error' => 'Invalid credentials.');
			}
		}
		$this->set('set_password',$set_password);
	}
  
	/**
	*Summary of Method: Search page of the site.
	*created by: 1497
	*date:  01-02-16
	* */
	public function search() {
		Configure::write('debug', 2);
		$this->set('site_title', 'Search');
		$this->set('searchmeta', utf8_encode('Trouvez rapidement un vétérinaire à  prenez rendez-vous gratuitement en ligne en quelques clics'));
	}  

	public function ajax_cal() {
		//Configure::write('debug', 2);
		$this->layout = false;
	}
	
	public function prev_ajax_cal() {
		//Configure::write('debug', 2);
		$this->layout = false;
	}
}
?>