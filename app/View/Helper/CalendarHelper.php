<?php

App::uses('Helper', 'View/Helper');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class CalendarHelper extends AppHelper {

	/**
	 * @Description : Check that user have added video to watchlist or not
	 * @video_id integer
	 * @logged_in_user integer
	**/
	
	public function getCalendar($vet_id) {
		$AvailabilitySetting = ClassRegistry::init('AvailabilitySetting');
		$array = $AvailabilitySetting->find("all", array(
			"conditions"=>array("AvailabilitySetting.vet_id"=>$vet_id,"status"=>1),
			"fields"=>array('group_concat(slots order by `id` ASC) AS Slots','available_date','appoint_start_time','appoint_end_time'),
			"group"=>'available_date',
			"order"=>'available_date,id ASC'
		));
		
		return $array;
	
	}
	
	public function nextdate($vet_id,$next_date) {
		
		$AvailabilitySetting = ClassRegistry::init('AvailabilitySetting');

		
		$array = $AvailabilitySetting->find("all", array(
			"conditions"=>array("AvailabilitySetting.vet_id"=>$vet_id,"AvailabilitySetting.status"=>1,"AvailabilitySetting.available_date >=" => $next_date),
			"fields"=>array('group_concat(slots order by `id` ASC) AS Slots','available_date','appoint_start_time','appoint_end_time'),
			"group"=>'available_date',
			"order"=>'id ASC'
		));

		
		return $array;


	}
	

	public function prevdate($vet_id,$next_date) {

		$AvailabilitySetting = ClassRegistry::init('AvailabilitySetting');
	
		$array = $AvailabilitySetting->find("all", array(
			"conditions"=>array("AvailabilitySetting.vet_id"=>$vet_id,"AvailabilitySetting.status"=>1,"AvailabilitySetting.available_date >=" => $next_date),
			"fields"=>array('group_concat(slots order by `id` ASC) AS Slots','available_date','appoint_start_time','appoint_end_time'),
			"group"=>'available_date',
			"order"=>'id ASC'
		));

		
		return $array;


	}
	

}
