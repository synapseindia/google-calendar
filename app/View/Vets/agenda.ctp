<div class="main">
 <div class="outer-admin">
  <div class="wrapper-admin">
<?php //echo $this->element('vet_sidebar'); ?>
 <div class="content-admin">
  <div class="content-admin-wrapper">
   <div class="content-admin-main">
	<div class="content-admin-main-inner dash-in">
	<div class="container-fluid">
	<div class="row">
	<div class="col-sm-12">
		<!--<a class="add-sync agenda--addappbtn login--popup fr-add-syc" href="javascript:;" style="max-width: 100%; display: none;">Add an appointment</a>	-->	
		<a class="add-sync agenda--addappbtn google--popup fr-add-syc" href="javascript:;" style="max-width: 100%; display: none;">Synchronize Google Calendar</a>
	</div>
	
	<?php if($appointment_type){ ?><div class="col-sm-12"><?php } else { ?><div class="col-sm-12"><?php } ?>
		<div class="dash-cal-sec fr-dash-cal" id="calendar"> <!-- Calender Div Start -->
		</div><!-- Calender Div End -->
		<div id="authorize-div">
			<span>To use Google Calendar Click the Authorize button</span>
			<!--Button for the user to click to initiate auth sequence -->
			<button id="authorize-button" class="agenda--addappbtn" style=" background: orange; border: none; color: black;">Authorize</button>
		</div>
		<div id="event-popup" style="display: block;"></div>
	</div><!-- /.col-* -->
	<!--<div class="col-sm-12">
		<a class="add-sync agenda--addappbtn login--popup" href="javascript:;" style="max-width: 100%; display: none;">Ajouter un RDV</a>		
		<a class="add-sync agenda--addappbtn google--popup" href="javascript:;" style="max-width: 100%; display: none;">Synchroniser Google Agenda</a>
	</div>-->
	<?php if($appointment_type){ ?>
	<div class="col-sm-12 bdr3btm">
		<h2 class="dash-hd-doc pr kindofapp fr-hd-kd">Appointment type</h2>
		<ul class="appointment-col-sec">
			<?php foreach($appointment_type as &$type){  ?>
			<li class="col-box">
				<span style="background: <?php echo '#'.$type['VetAppointmentType']['colour']; ?> none repeat scroll 0 0" title="<?php echo $type['AppointmentType']['name']; ?>"></span>
			</li>
			<?php } unset($type); ?>
		</ul><div class="clearfix"></div>
	</div><!-- /.col-* -->
	<?php } ?>
</div><!-- /.row -->
	   
	   </div><!-- /.container-fluid -->
	  </div><!-- /.content-admin-main-inner -->
	 </div><!-- /.content-admin-main -->
	</div><!-- /.content-admin-wrapper -->
   </div><!-- /.content-admin -->
  </div><!-- /.wrapper-admin -->
 </div><!-- /.outer-admin -->
</div><!-- /.main -->
<!-- Include full calendar scripts  -->
<?php echo $this->Html->css(array('frontend/assets/libraries/fullcalendar/fullcalendar.css'));
echo $this->Html->script(array('frontend/assets/libraries/fullcalendar/lib/moment.min.js','frontend/assets/libraries/fullcalendar/fullcalendar.min.js','frontend/assets/libraries/fullcalendar/lang-all.js','frontend/assets/libraries/fullcalendar/gcal.js','frontend/assets/others/calendar.js')); 
echo $this->Html->script('frontend/assets/libraries/datepicker/new/bootstrap-datepicker.js'); ?>
<script src="https://apis.google.com/js/client.js?onload=checkAuth"></script>
<div class="login--popup-cont">
 <div class="close-all"></div>
 <div class="login-reg-form" style="max-width:650px;">
  <div class="row">
  <div class="col-sm-12">
	<h2 class="dash-hd-doc pr btm-bdr">Add an appointment</h2>
	<div class="background-white">
	<?php echo $this->Form->create('Appointment', array('url' => array('controller' => 'appointments', 'action' => 'personal'),'class'=>'form-inline','type'=>'post','role'=>'form')); ?>
	<?php echo $this->Form->hidden('Appointment.overwrite',array('value' => base64_encode('false'))); ?>
	<div class="time-slots">
		<div class="time-slots-wd table_width">
		<div class="clearfix pad-b-ts ts-box">
		<div class="left">Comment <span>*</span></div>
		<div class="right">
		 <div class="form-group bot-mrgn add--ts">
		  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clearfix">
			<?php echo $this->Form->input('Appointment.description', array('type'=>'textarea', 'label'=>false,'div'=>false,'rows' => 2,'class'=>'form-control','placeholder'=>'Commentaires','style' => 'max-width: 100%;','required' => true)); ?>
		  </div><!--close columns-->
		 </div><!-- /.form-group -->
		</div>
		</div><!-- ./ts-box -->
		<div class="clearfix pad-b-ts ts-box">
		<div class="left">Date <span>*</span></div>
		<div class="right">
		 <div class="form-group bot-mrgn add--ts">
		  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 clearfix">
			<label>From</label>
			<div class="input-group input-append date">
			<?php echo $this->Form->input('Appointment.filter_start', array('type'=>'text', 'label'=>false,'div'=>false,'class'=>'form-control','placeholder'=> utf8_encode('Début'),'required' => true)); ?>
			<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		  </div><!--close columns-->
		  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 clearfix">
			<label>To</label>
			<div class="input-group input-append date">
			<?php echo $this->Form->input('Appointment.filter_end', array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','placeholder'=> utf8_encode('Fin'),'required' => true)); ?>
			<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		  </div>									
		 </div><!-- /.form-group -->
		</div>
		</div><!-- ./ts-box -->							
		<div class="clearfix pad-b-ts ts-box mb0">
		<div class="left">Schedule <span>*</span></div>
		<div class="right">
		<div class="form-group bot-mrgn add--ts">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 clearfix">					
			<label>De</label>
			<?php echo $this->Form->input('Appointment.appoint_start_time', array('options' => array($time_slots),'empty' => 'Select...','label' => false,'div' => false,'class'=>'form-control','id' => 'fromslot','required' => true)); ?>
		</div>
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 clearfix">				
			<label><?php echo utf8_encode('À'); ?></label>
			<?php echo $this->Form->input('Appointment.appoint_end_time', array('options' => array($time_slots),'empty' => 'Select...','label' => false,'div' => false,'class'=>'form-control','id' => 'toslot','required' => true)); ?>
		</div>			
		</div><!-- /.form-group -->
		</div>
		</div><!-- ./ts-box -->
		</div><!-- ./time-slots-wd -->
	</div><!-- /.time-slots -->
	<div class="clearfix center">
		<button type="button" class="btn btn-primary ts-btn rem-bucket-icon" onclick="javascript:personalAppointment(false);"><i class="fa fa-shopping-cart"></i> Record</button>
	</div><!-- ./pad-b-ts -->
	<?php echo $this->Form->end(); ?>    
	</div>
  </div><!-- /.col-* -->
  </div><!-- /.row -->
  <a href="javascript:void(0)" class="close-x close--popup">X</a>
 </div>
</div>
<div class="google--popup-cont">
 <div class="close-all"></div>
 <div class="login-reg-form google-reg-form" style="max-width:650px;">
  <div class="row">
  <div class="col-sm-12">
	<h2 class="dash-hd-doc pr btm-bdr">Sync with Google Calendar</h2>
	<div class="background-white">
	<?php echo $this->Form->create('Appointment', array('url' => array('controller' => 'appointments', 'action' => 'sync'),'class'=>'form-inline','type'=>'post','role'=>'form','id'=>'google-sync')); ?>
	<div class="time-slots">
		<div class="time-slots-wd table_width">
		<div class="clearfix pad-b-ts ts-box">
		<div class="left">Date <span>*</span></div>
		<div class="right">
		 <div class="form-group bot-mrgn add--ts">
		  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 clearfix">
			<label>From</label>
			<div class="input-group input-append date">
			<?php echo $this->Form->input('Appointment.filter_start', array('type'=>'text', 'label'=>false,'div'=>false,'id'=>false,'class'=>'form-control','placeholder'=>utf8_encode('Date From'))); ?>
			<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		  </div><!--close columns-->
		  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 clearfix">
			<label>To</label>
			<div class="input-group input-append date">
			<?php echo $this->Form->input('Appointment.filter_end', array('type'=>'text','label'=>false,'div'=>false,'id'=>false,'class'=>'form-control','placeholder'=>utf8_encode('Date To'))); ?>
			<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
			</div>
		  </div>									
		 </div><!-- /.form-group -->
		</div>
		</div><!-- ./ts-box -->
		</div><!-- ./time-slots-wd -->
	</div><!-- /.time-slots -->
	<div class="clearfix center">
		<button type="button" onclick="javascript:syncAppointment();" class="btn btn-primary ts-btn rem-bucket-icon"><i class="fa fa-shopping-cart"></i>Record</button>
	</div><!-- ./pad-b-ts -->
	<?php echo $this->Form->end(); ?>    
	</div>
  </div><!-- /.col-* -->
  </div><!-- /.row -->
  <a href="javascript:void(0)" class="close-x close--popup">X</a>
 </div>
</div>
<div class="preloaderView"></div>
<script type="text/javascript">
$(document).ready(function(){
//$('.date').datepicker({format: 'dd/mm/yyyy',locale:'en'/*,startDate: '1d'*/});

$.fn.datepicker.defaults.language = 'en';
//$('#birth_picker').datepicker({format: 'dd/mm/yyyy',endDate: '0d', autoclose:true});
$('.date').datepicker({
	todayHighlight:'TRUE',
	startDate: '-0d',
	//endDate: '0d',
	autoclose: true
	
});

$('.date').click(function(){var lef = $(this).offset().left; $('.datepicker.datepicker-dropdown.dropdown-menu').css({'left':lef}); });
$('.input-group-addon.add-on').on('click',function(){	$('.date').focus();	});

});
// var GOOGLE_APP_BROWSER_KEY = '<?php echo Configure::read('App.google_app_browser_key'); ?>';
// var GOOGLE_OAUTH_CLIENT_ID = '<?php echo Configure::read('App.google_oauth_client_id'); ?>';

// alert(GOOGLE_APP_BROWSER_KEY);
</script>
<style>.bdr3btm{ border-bottom:1px solid #eee; margin: 0 15px; padding: 0 0 5px;}h2.dash-hd-doc.kindofapp{margin: 0 0 10px;}ul.appointment-col-sec li{ margin-bottom:7px; float: left;}ul.appointment-col-sec li span{height: 25px; width: 35px;}p.has-error{border-color:red;}</style>