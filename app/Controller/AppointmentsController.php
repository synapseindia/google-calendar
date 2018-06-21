<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class AppointmentsController extends AppController {

	public $name = 'Appointments';
	public $uses = array('Appointment','AppointmentType','AvailabilitySetting','VetImage');
	public $helpers = array();
	public $components = array('Paginator', 'RequestHandler');
  
	
	

	
  	/**
	*Summary of Method: Clients Appointment response
	*created by: 1598
	*date:  14-04-16
	* */
	public function clientresponse(){
		//$this->checkVetLogin();
		$this->autoRender = false;
		$data = array();
		
		// check for proper form submit.
		if ( $this->request->is('ajax') && $this->request->is('post') ){
			// if appointment id exists and vet is assigned to that appointment.
			if ($this->Appointment->hasAny(array('Appointment.appointment_id' => trim($this->request->data['AppointmentComment']['appointment_id']),'Appointment.client_id' => $this->Session->read('client.id')))){
				// check if comment provided or not.
				if ( $this->request->data['AppointmentComment']['comment'] ){
					
					switch ($this->request->data['AppointmentComment']['status']) {
						
						// Cancel
						case 3:
							$this->loadModel('AppointmentComment');
							$this->loadModel('AvailabilitySetting');
							
							
							$appointment = $this->Appointment->findByAppointment_id(trim($this->request->data['AppointmentComment']['appointment_id']));
							
							$vet_id = $appointment['Appointment']['vet_id'];
							$dateRequest = $appointment['Appointment']['appointment_date'];
							
							$fr_time_slot = $appointment['Appointment']['slot_start'];
							$to_time_slot = $appointment['Appointment']['slot_end'];
							
							$getAvailabilitySettingdata = $this->AvailabilitySetting->find("all",array("conditions"=>array("status"=>0,"available_date"=>$dateRequest,"vet_id"=>$vet_id,"slots >="=>$fr_time_slot,"slots <="=>$to_time_slot)));
							
							if(count($getAvailabilitySettingdata)>0){
								
								foreach($getAvailabilitySettingdata as $row){
									// updating Availability Status
									$this->AvailabilitySetting->id = $row['AvailabilitySetting']['id'];
									$this->AvailabilitySetting->saveField('status',1);
								}
							}
							
							// add comment and status to comments table
							$this->request->data['AppointmentComment']['appointment_id'] = $appointment['Appointment']['id'];
							$this->request->data['AppointmentComment']['client_id'] = $this->Session->read('client.id');
							$this->request->data['AppointmentComment']['vet_id'] = $vet_id;
							// client is commenting for vet
							$this->request->data['AppointmentComment']['to_vet'] = 1;
							$this->AppointmentComment->create();
							if($this->AppointmentComment->save($this->request->data)){
								// update status in appointment table
								$this->Appointment->id = $appointment['Appointment']['id'];
								$this->Appointment->saveField('status', $this->request->data['AppointmentComment']['status']);
								$data = array( 'success' => 'Appointment status updated successfully.', 'redirect' => 'appointments/vet' );
								
								$customerSubject = utf8_encode("Votre rendez-vous a bien été annulé");
								$vetSubject = utf8_encode("Votre rendez-vous a été annulé");
								
								$clientCancelTag = utf8_encode("Vous avez annulé votre rendez-vous");
								$vetCancelTag = utf8_encode("Votre rendez-vous a été annulé");
								
								$this->sendMailtoCustomer($this->request->data,$appointment,$clientCancelTag,$customerSubject);
								$this->sendMailtoVet($this->request->data,$appointment,$vetCancelTag,$vetSubject);
								
								
								
								$data = array( 'success' => 'Appointment status updated successfully.', 'redirect' => 'appointments/client' );
							}else{
								$data = array( 'error' => 'Oh snap! Some error occurred ! Please try again later.' );
							}
						
						break;
						default:
							$data = array( 'error' => utf8_encode('Merci d’ajouter un commentaire.'));
					}					
				} else {
					$data = array( 'error' => 'Vous devez ajouter un commentaire.' );
				}
			} else {
				$data = array( 'error' => utf8_encode('Oups ! Nous n’avons pas trouvé l’animal. Rafraîchissez la page et réessayez.'));
			}
		} else {
			$data = array( 'error' => utf8_encode('Oups ! Impossible de vous identifier. Réessayez.'));
		}
		echo json_encode($data);		
	}
	
/* Testing functions below. */
	public function mytimeslots(){
		$this->checkVetLogin();
		$this->layout = 'clientpage';
		$this->set('disabled',1);
	}

	public function add_slot(){
		$this->checkVetLogin();
		$this->layout = 'clientpage';
		$this->set('disabled',1);
		$start_date= '2016-03-05';
		$end_date = '2016-05-04';
		$day_of_week = date("N", strtotime($start_date));
		while (strtotime($start_date) <= strtotime($end_date)) {
            if($day_of_week < 7) { /* weekday */
		       $dt[]=$start_date;
		    } 
            $start_date = date ("Y-m-d", strtotime("+1 day", strtotime($start_date)));
            $day_of_week = date("N", strtotime($start_date));
        }
        if(count($dt)>0){
	        foreach($dt as $date){
	        	$vet_id =177;
				$available_date = $date;
				$start = '10:30';
				$end = '16:00';
				$by = '5 mins';
				$start_time = strtotime($start); 
			   	$end_time   = strtotime($end); 
			   	$current    = time(); 
			   	$add_time   = strtotime('+'.$by, $current); 
			   	$diff       = $add_time-$current; 
			   	$times = array(); 
			   	while ($start_time < $end_time) { 
			       $times[] = $start_time; 
			       $start_time += $diff; 
			    } 
			  	$times[] = $start_time; 
			  	foreach ($times as $key => $time) { 
				    $times[$key] = date('G:i', $time); 
				    $AvailabilitySetting = $this->AvailabilitySetting->create();
				    $AvailabilitySetting['AvailabilitySetting']['vet_id'] = $vet_id;
				    $AvailabilitySetting['AvailabilitySetting']['available_date'] = $available_date;
				    $AvailabilitySetting['AvailabilitySetting']['appoint_start_time'] = $start;
				    $AvailabilitySetting['AvailabilitySetting']['appoint_end_time'] = $end;
					$AvailabilitySetting['AvailabilitySetting']['slots'] = date('G:i', $time);
					$AvailabilitySetting['AvailabilitySetting']['created'] = date('Y-m-d H:i:s');
					$AvailabilitySetting['AvailabilitySetting']['modified'] =date('Y-m-d H:i:s');
				} 
	        }
    	}
	}
	
	/**
	*Summary of Method: Lists all Appointments 
	*created by: 1497
	*date:  11-05-16
	* */
	public function getEventDetails() {
		$this->checkVetLogin();
		$data = array();
		// check for proper form submit.
		if ( $this->request->is('ajax') && $this->request->is('get') ){
			// if appointment id exists and vet is assigned to that appointment.
			if ($this->Appointment->hasAny(array('Appointment.appointment_id' => trim($this->request->query['appointment_id']),'Appointment.vet_id' => $this->Session->read('vet.id')))){
				$data = $this->Appointment->find('first',array('conditions' => array('Appointment.vet_id' => $this->Session->read('vet.id'), 'Appointment.appointment_id' => trim($this->request->query['appointment_id']))));
				if( $data['Appointment']['appointment_type_id'] == $data['Appointment']['client_id'] && $data['Appointment']['client_id'] == $data['Appointment']['pet_id'] && $data['Appointment']['client_id'] == 0 ){
					$data['personal'] = true;
				} else {
					$data['personal'] = false;
				}
				$this->loadModel('Pet');
				$pet = $this->Pet->getTypeandBreed($data['Appointment']['pet_id']);
				$this->Pet->unbindModel(array('hasMany' => array('PetMedicine','PetComment','PetVaccine','PetWeight','PetHeight','PetRibcage','PetAnkle')));
				$pet_det = $this->Pet->findById($data['Appointment']['pet_id'],array('pet_id','name','age'));
				$data = array_merge( (array)$data, (array)$pet );
				$data = array_merge( (array)$data, (array)$pet_det );
			} else {
				$data['message'] = 'Unable to find details. Please try again later.';
			}
		} else {
			$data['message'] = 'Unable to find details. Please try again later.';
		}
		$this->set('data',$data);
	}
	
	/**
	*Summary of Method: Create personal appointment
	*created by: 1497
	*date:  12-05-16
	* */
	
	public function personal(){
		$this->checkVetLogin();
		Configure::write('debug', 2);
  		$this->autoRender = false;
		$data = array();
		// check for proper form submit.
		if ( $this->request->is('ajax') && $this->request->is('post') ){
			$data = $this->validatePersonal($this->request->data);			
			if(empty($data)){
				$appointments = array();
				$filter_start = str_replace('/', '-', $this->request->data['Appointment']['filter_start']);
				$filter_end = str_replace('/', '-', $this->request->data['Appointment']['filter_end']);
				
				$start_date = strtotime($filter_start);
				$end_date = strtotime($filter_end);			
				for( $i = $start_date; $i <= $end_date; ){
					$save = array(
						'title' 			=> $this->request->data['Appointment']['description'],
						'vet_id' 			=> $this->Session->read('vet.id'),
						'client_id' 		=> 0,
						'pet_id' 			=> 0,
						'appointment_type_id' => 0,
						'appointment_date' 	=> date('Y-m-d',$i),
						'slot_start' 		=> $this->request->data['Appointment']['appoint_start_time'],
						'slot_end' 			=>  $this->request->data['Appointment']['appoint_end_time'],
						'status' 			=> 1
					);
					$this->Appointment->create();
					$this->Appointment->save($save);
					
					$this->Appointment->id = $this->Appointment->getLastInsertId();
					$appointment = $this->Appointment->field('Appointment.appointment_id');
					
					$stdate = date_create( date('Y-m-d',$i). $this->request->data['Appointment']['appoint_start_time']);
					$start = date_sub($stdate, date_interval_create_from_date_string('2 hours'));
					$edate = date_create( date('Y-m-d',$i). $this->request->data['Appointment']['appoint_end_time']);
					$end = date_sub($edate, date_interval_create_from_date_string('2 hours'));
					
					$appointments[$appointment] = array(
							'summary' => $this->request->data['Appointment']['description'],
							'start' => array(
								'dateTime' => date_format($start,DATE_ATOM),
								'timeZone' => 'Europe/Paris'
							),
							'end' => array(
								'dateTime' => date_format($end,DATE_ATOM),
								'timeZone' => 'Europe/Paris'
							)
						);
					$i = strtotime("+1 day", $i);
				}

				$dbo = $this->AvailabilitySetting->getDatasource();
				$value = $dbo->value('Doctor\'s Personal Appointment', 'string');
				$this->AvailabilitySetting->updateAll(
					array('AvailabilitySetting.status' => 2, 'AvailabilitySetting.comment' => $value),
					// conditions
					array(
						'AvailabilitySetting.available_date BETWEEN ? AND ?' => array(
							date('Y-m-d',strtotime($filter_start)), 
							date('Y-m-d',strtotime($filter_end))
						),
						'AvailabilitySetting.vet_id' => $this->Session->read('vet.id'),
						'AvailabilitySetting.status' => 1,
						
						'TIME(AvailabilitySetting.slots) >=' =>date('H:i:s',strtotime($this->request->data['Appointment']['appoint_start_time'])),
						'TIME(AvailabilitySetting.slots) <=' =>date('H:i:s',strtotime('+ 5 mins', strtotime($this->request->data['Appointment']['appoint_end_time'])))
						
						
					)
				);
				
				$data = $appointments;
				
			}
		} else {
			$data['message'] = 'Unable to find details. Please try again later.';
		}
		echo json_encode($data);
	}
	
	/**
	*Summary of Method: Validate personal appointment before creating
	*created by: 1497
	*date:  02-06-16
	* */
	protected function validatePersonal($data) {
		$return = array();
		if(empty($data['Appointment']['description'])){
			$return['error']['description'] = 'Please provide some description.';
		}
		if(empty($data['Appointment']['filter_start'])){
			$return['error']['filter_start'] = 'Please provide start date.';
		}
		if(empty($data['Appointment']['filter_end'])){
			$return['error']['filter_end'] = 'Please provide end date.';
		}
		if(empty($data['Appointment']['appoint_start_time'])){
			$return['error']['appoint_start_time'] = 'Please provide start time.';
		}
		if(empty($data['Appointment']['appoint_end_time'])){
			$return['error']['appoint_end_time'] = 'Please provide end time.';
		}
		if(!empty($return)){
			return $return;
		}
		$filter_start = str_replace('/', '-', $data['Appointment']['filter_start']);
		$filter_end = str_replace('/', '-', $data['Appointment']['filter_end']);
		
		
		// find if any appointment is booked
		$conditions_2 = array(
			'Appointment.appointment_date BETWEEN ? AND ?' => array(
				date('Y-m-d',strtotime($filter_start)), 
				date('Y-m-d',strtotime($filter_end))
			),
			'Appointment.slot_start' => $data['Appointment']['appoint_start_time'],
			'Appointment.slot_end' => $data['Appointment']['appoint_end_time'],
		);
		$get_booked_appointments = $this->Appointment->find('all', array('conditions'=>$conditions_2));
		// if any appointment exists/ slots already booked between the said time then do not proceed untill vet gives confirmation.
		if( !empty($get_booked_appointments) && base64_decode($data['Appointment']['overwrite']) !== 'true' ){
			$return['message'] = utf8_encode('Il semble y avoir des rendez-vous aux dates sélectionnées. Voulez-vous les supprimer ?');
			$return['appointments'] = utf8_encode('Il semble y avoir des rendez-vous aux dates sélectionnées. Voulez-vous les supprimer ?');
		} else if( !empty($get_booked_appointments) && base64_decode($data['Appointment']['overwrite']) === 'true' ) {
			// $get_booked_slots;
			// slots were already booked. and will remain booked. update the appointments as cancelled and intimate the concerned.
			foreach($get_booked_appointments as &$appointment){
				$this->Appointment->id = $appointment['Appointment']['id'];
				$this->Appointment->saveField('status',3);
				$appointment['Appointment']['status'] = 3;
				$request['AppointmentComment']['status'] = 3;
				$request['AppointmentComment']['comment'] = '';
				if( $appointment['Appointment']['client_id'] != 0 && $appointment['Appointment']['pet_id'] != 0 && $appointment['Appointment']['appointment_type_id'] != 0 ){
					$this->sendMailtoCustomer($request,$appointment);
					$this->sendSMStoCustomer($request,$appointment);
				}
				$this->sendMailtoVet($request,$appointment);
			} unset($appointment);
		}
		//find all slots for the given dates.
		$conditions_3 = array(
			'AvailabilitySetting.available_date BETWEEN ? AND ?' => array(
				date('Y-m-d',strtotime($filter_start)), 
				date('Y-m-d',strtotime($filter_end))
			) ,
			'OR' => array (
				array(
					'AvailabilitySetting.slots' => $data['Appointment']['appoint_start_time']),
				array(
					'AvailabilitySetting.slots' => $data['Appointment']['appoint_end_time'])
				),
			'AvailabilitySetting.vet_id' => $this->Session->read('vet.id'),
			'AvailabilitySetting.status' => 1
		);
		$get_all_slots = $this->AvailabilitySetting->find('all', array('conditions'=>$conditions_3,'order'=>'AvailabilitySetting.id'));
		// if the slot time input by user exists then disable them
		if( empty($get_all_slots) ){
			$return['message'] = utf8_encode('Il n’y a aucun horaire disponible. Créez un créneau horaire dans vos réglages avant de prendre un rendez-vous personnel.');
		}
		return $return;
	}
	
	/**
	*Summary of Method: remove personal appointment
	*created by: 1497
	*date:  13-05-16
	* */
	public function remove(){
		$this->checkVetLogin();
		Configure::write('debug', 2);
  		$this->autoRender = false;
		$data = array();
		// check for proper form submit.
		if ( $this->request->is('ajax') && $this->request->is('get') ){
			$conditions = array(
				'Appointment.appointment_id' => trim($this->request->query['id']),
				'Appointment.vet_id' => $this->Session->read('vet.id'),
				'Appointment.appointment_type_id' => 0,
				'Appointment.client_id' => 0,
				'Appointment.pet_id' => 0
			);
			if( !empty($this->request->query['id']) && $this->Appointment->hasAny($conditions) ){
				$appointment = $this->Appointment->find('first',array('conditions' => $conditions));
				// enable all the block slots.
				$this->AvailabilitySetting->updateAll(
					array( 'AvailabilitySetting.status' => 1, 'AvailabilitySetting.comment' => null ),
					// conditions
					array(
						'AvailabilitySetting.available_date' => $appointment['Appointment']['appointment_date'],
						'AvailabilitySetting.vet_id' => $this->Session->read('vet.id'),
						'AvailabilitySetting.status' => 2,
						'AvailabilitySetting.slots BETWEEN ? AND ?' => array(		
						  $appointment['Appointment']['slot_start'],
						  $appointment['Appointment']['slot_end']
						)
					)
				);
				$this->Appointment->deleteAll(array('Appointment.appointment_id' => trim($this->request->query['id'])), false);
				$data['message'] = 'Personal appointment has been successfully removed.';
				$data['redirect'] = '/vets/agenda';
				$data['success'] = 1;
			} else {
				$data['message'] = 'Unable to find details. Please try again later.';
			}
		} else {
			$data['message'] = 'Unable to authenticate. Please try again later.';
		}
		echo json_encode($data);
	}
	
	/**
	*Summary of Method: Google sync section
	*created by: 1497
	*date:  13-05-16
	* */
	public function sync(){
		
		Configure::write('debug', 2);
  		$this->autoRender = false;
		$data = array(); $return = array();
		// check for proper form submit.
		if ( $this->request->is('ajax') && $this->request->is('post') ){
			if( !empty($this->request->data['Appointment']['filter_start']) && !empty($this->request->data['Appointment']['filter_end']) ) {
				$filter_start = str_replace('/', '-', $this->request->data['Appointment']['filter_start']);
				$filter_end = str_replace('/', '-', $this->request->data['Appointment']['filter_end']);
				
				$filter_start1 = explode("-", $filter_start);
				$filter_start = $filter_start1[2].'-'.$filter_start1[0].'-'.$filter_start1[1];
				
				$filter_end1 = explode("-", $filter_end);
				$filter_end = $filter_end1[2].'-'.$filter_end1[0].'-'.$filter_end1[1];
				
				// retrieve all non personal appointments and send for sync.
				$appointments = $this->Appointment->find('all',
				array('conditions' => array(
					'Appointment.vet_id' => $this->Session->read('vet.id'),
					'Appointment.client_id <>' => 0,
					'Appointment.pet_id <>' => 0,
					'Appointment.appointment_type_id <>' => 0,
					'Appointment.is_sync' => 0,
					'Appointment.appointment_date BETWEEN ? AND ?' => 
						array(
							date('Y-m-d',strtotime($filter_start)), 
							date('Y-m-d',strtotime($filter_end))
						)
					),'order'=>'Appointment.appointment_date')
				);
				
				if (!empty($appointments)){
					foreach( $appointments as &$appointment ){
						
						
						$stdate = date_create($appointment['Appointment']['appointment_date']. $appointment['Appointment']['slot_start']);
						$start = date_sub($stdate, date_interval_create_from_date_string('2 hours'));
						$edate = date_create($appointment['Appointment']['appointment_date']. $appointment['Appointment']['slot_end']);
						$end = date_sub($edate, date_interval_create_from_date_string('2 hours'));
						
						$return[$appointment['Appointment']['appointment_id']] = array(
							'summary' => $appointment['Appointment']['title'],
							'description' => $appointment['Appointment']['description'],
							'start' => array(
								'dateTime' => date_format($start,DATE_ATOM),
								'timeZone' => 'Europe/Paris'
							),
							'end' => array(
								'dateTime' => date_format($end,DATE_ATOM),
								'timeZone' => 'Europe/Paris'
							)
						);
					}
					
					$data = $return;
					
					echo json_encode($data);die;
				} else {
					$data['message'] = 'No appointment found. Please try again.';
				}				
			} else {
				$data['message'] = 'Please provide all details.';
			}
		} else {
			$data['message'] = 'Unable to authenticate. Please try again later.';
		}
		echo json_encode($data);die;
	}
	
	/**
	*Summary of Method: Google sync section
	*created by: 1497
	*date:  13-05-16
	* */
	public function syncupdate(){
		
		Configure::write('debug', 2);
  		$this->autoRender = false;
		$data = array(); $return = array();
		// check for proper form submit.
		if ( $this->request->is('ajax') && $this->request->is('get') ){
			$conditions = array(
				'Appointment.appointment_id' => trim($this->request->query['id']),
				'Appointment.vet_id' => $this->Session->read('vet.id'),
				'Appointment.is_sync' => 0
			);
			if( !empty($this->request->query['id']) && !empty($this->request->query['value']) && $this->Appointment->hasAny($conditions) ){
				$appointment = $this->Appointment->findByAppointment_id($this->request->query['id']);
				$this->Appointment->id = $appointment['Appointment']['id'];
				$this->Appointment->saveField('google_sync_data',json_encode($this->request->query['value']));
		
				$data['message'] = 'Successfully updated.';
				$data['id'] = $this->request->query['id'];
			} else {
				$data['message'] = 'Unable to find details. Please try again later.';
			}
		} else {
			$data['message'] = 'Unable to authenticate. Please try again later.';
		}
		echo json_encode($data);
	}
	
	/**
	*Summary of Method: Google calendar with Login
	*created by: 1497 - on discussion
	*date:  14-05-16
	* */
	
	public function calendar(){
		$this->layout = 'clientpage';
	}
	
	/**
	*Summary of Method: Google Plus account details
	*created by: 1497 - on discussion
	*date:  14-05-16
	* */
	
	public function syncuser(){
		// $this->checkVetLogin();
		Configure::write('debug', 2);
  		$this->autoRender = false;
		$data = array(); $return = array();
		$this->loadModel('VetCalendar');
		// check for proper form submit.
		if ( $this->request->is('ajax') && $this->request->is('get') ){
			$conditions = array(
				'VetCalendar.vet_id' => $this->Session->read('vet.id'),
			);
			if( !empty($this->request->query['value']) && $this->VetCalendar->hasAny($conditions) ){
				$conditions = array(
					'VetCalendar.google_user_id' => $this->request->query['value']['id'],
					'VetCalendar.vet_id' => $this->Session->read('vet.id'),
				);
				if ($this->VetCalendar->hasAny($conditions)){
					$data['success'] = 'Successfully Authenticated. Please proceed to next step.';
					$return = $this->VetCalendar->findAllByVet_idAndGoogle_user_id($this->Session->read('vet.id'),$this->request->query['value']['id'],array('id','vet_id','google_user_id','calendar_id'));
					$data['calendar'] = $return;
				} else {
					$data['error'] = 'You seem to have logged in to a different account. Are you sure you want to continue?';
					$data['type'] = 'account';
				}
			} else {
				$save =array(
					'vet_id' => $this->Session->read('vet.id'),
					'google_user_id' => $this->request->query['value']['id'],
					'google_auth_data' => json_encode($this->request->query['value'])
				);
				$this->VetCalendar->create();
				$this->VetCalendar->save($save);
				$data['success'] = 'Successfully Authenticated. Please proceed to next step.';
				$data['calendar'] = '';
			}
		} else {
			$data['error'] = 'Unable to authenticate. Please try again later.';
			$data['type'] = 'authentication';
		}
		echo json_encode($data);
	}
	
	/**
	*Summary of Method: Google Plus new account details
	*created by: 1497 - on discussion
	*date:  14-05-16
	* */
	
	public function syncguser(){
		
		Configure::write('debug', 2);
  		$this->autoRender = false;
		$data = array(); $return = array();
		$this->loadModel('VetCalendar');
		// check for proper form submit.
		if ( $this->request->is('ajax') && $this->request->is('get') ){
			$save =array(
				'vet_id' => $this->Session->read('vet.id'),
				'google_user_id' => $this->request->query['value']['id'],
				'google_auth_data' => json_encode($this->request->query['value'])
			);
			$this->VetCalendar->create();
			$this->VetCalendar->save($save);
			$data['success'] = 'Successfully Authenticated. Please proceed to next step.';
			$data['calendar'] = '';
		} else {
			$data['error'] = 'Unable to authenticate. Please try again later.';
			$data['type'] = 'authentication';
		}
		echo json_encode($data);
	}
	
	/**
	*Summary of Method: Google Plus set user primary calendar details
	*created by: 1497 - on discussion
	*date:  14-05-16
	* */
	
	public function syncusercal(){
		
		Configure::write('debug', 2);
  		$this->autoRender = false;
		$data = array(); $return = array();
		$this->loadModel('VetCalendar');
		// check for proper form submit.
		if ( $this->request->is('ajax') && $this->request->is('get') ){
			$user = json_decode($this->request->query['user'],true);
			$vet_cal = $this->VetCalendar->findByVet_idAndGoogle_user_id($this->Session->read('vet.id'),$user[0]['VetCalendar']['google_user_id']);
			$save =array(
				'calendar_id' => $this->request->query['value']['id'],
				'calendar_auth_data' => json_encode($this->request->query['value'])
			);
			$this->VetCalendar->id = $vet_cal['VetCalendar']['id'];
			$this->VetCalendar->save($save);
			$data['success'] = 'Successfully Authenticated. Please proceed to next step.';
			$data['calendar'] = array_merge( (array)$vet_cal['VetCalendar'], (array)$save );
		} else {
			$data['error'] = 'Unable to authenticate. Please try again later.';
			$data['type'] = 'authentication';
		}
		echo json_encode($data);
	}
}
?>