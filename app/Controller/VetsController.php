<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');


class VetsController extends AppController {
  
  public $components = array('Paginator', "RequestHandler");

  public function beforeFilter() {
    parent::beforeFilter();
  }
 
	/**
    *Summary of Method: Vet's agenda
	*created by: 1497
	*date:  17-02-16
	* 
	*/
	public function agenda(){



		$this->layout = 'clientpage';
		$this->set('disabled',$this->disabled);
		$this->set('site_title', 'My Agenda');
		// get main details from session
		$this->loadModel('VetAppointmentType');
		$appointment_type = array();

		$vet_appointment_for_month = $this->getVetAgendaList();
		$vet_appointment_for_month = '';
		$this->set('appointments',$vet_appointment_for_month);
		$this->set('appointment_type',$appointment_type);
		$settings = array();
		if($settings){
			$this->set('time_slots',$this->vetTimeSlots($settings['Setting']['appoint_start_time'],$settings['Setting']['appoint_end_time']));
		} else {
			$this->set('time_slots',$this->vetTimeSlots());
		}
	}
	
	/*
	*Summary of Method: Get Vet's agenda list in ajax
	*created by: 1497
	*date:  23-02-16
	*/
	public function getAgendaList(){
		$this->autoRender = false;
		$month = $this->request->query['month'];
		$year = $this->request->query['year'];
		$data = $this->getVetAgendaList($month,$year);
		echo $data;
	}
	
	protected function getVetAgendaList($month = null,$year = null){
		if( $this->Session->check('vet') ){
			if( $this->Session->read('vet.id') ){
				// cant define in paramters so define here. month
				$month = $month ? $month : date('m');
				// cant define in paramters so define here. year
				$year = $year ? $year : date('Y');
				// other used variables declaration
				$data = $vet_appointments = $colour = $appointments = array();
				// get all appointments of the vet for the current month.
				$this->loadModel('Appointment');
				$this->loadModel('VetAppointmentType');
				$vet_appointments = $this->Appointment->find('all',array(
					'conditions'=>array(
						'AND' => array(
							'Appointment.vet_id' => $this->Session->read('vet.id'), 
							'MONTH(Appointment.appointment_date)' => $month, 
							'YEAR(Appointment.appointment_date)' => $year
							
						),
						'OR' => array(
                              array('Appointment.status' => 1),
                              array('Appointment.status' => 2),
							  array('Appointment.status' => 5)
                        )
					),
					'order'=>'Appointment.appointment_date'
				));
				foreach ($vet_appointments as &$vet_appointment){
					
					// format data as per full calendar return types for direct render
					$start = date_create( $vet_appointment['Appointment']['appointment_date']. $vet_appointment['Appointment']['slot_start'] );
					$end = date_create( $vet_appointment['Appointment']['appointment_date']. $vet_appointment['Appointment']['slot_end'] );

					$appointments[] = array(
						'title' => $vet_appointment['Appointment']['title'],
						'start'	=> date_format($start,DATE_ATOM),
						'end'	=> date_format($end,DATE_ATOM),
						'client'	=> "Client Name",
						'vet'		=> "Requester Name",
						'color' => (!empty($colour))?'#'.$colour['VetAppointmentType']['colour']:'#387fea', /* append # so that full calendar will render properly */
						'appointment_id' => $vet_appointment['Appointment']['appointment_id']
					);
				} unset($vet_appointment);
				$data = $appointments;
			} else {
				$data = array();
			}
		} else {
			$data = array();
		}
		return json_encode($data);
	}
	
	/**
	*Summary of Method: time slot section for vet appointment management
	*created by: 1497
	*date:  12-05-16
	* */	
	public function vetTimeSlots( $start = '7:00', $end = '22:00' ){
		// static time slots for the vet section.
		// default start time is 07:00 hrs, end time is 22:00 hrs
		// gap in slots is of 5 minutes
		list($start_hour, $start_minutes) = explode(':',$start);
		list($end_hour, $end_minutes) = explode(':',$end);

		for( $i = $start_hour; $i <= $end_hour; $i++  ){
			for( $j = (int)$start_minutes; $j < 60; $j+=5){				
				// append 0 manually as it is removed when value is below 10.
				$j = $j < 10 ? '0'.$j : $j ;
				
				// create the slot array
				$time_slots[$i.':'.$j] = $i.':'.$j;
				
				// if end minute is not 60, then check for hour and break the loop.
				if ($i == $end_hour && $j == $end_minutes) { break; }
			}
			$start_minutes = 0;
		}
		// time slots to be used in appointment slot start and appointment slot end time.
		return $time_slots;
	}
	



			
			
			
			
		
		}
	
?>