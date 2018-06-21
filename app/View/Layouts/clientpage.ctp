<?php echo $this->Html->docType('html5'); ?>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo (!empty($site_title))?$site_title:'Page :'; ?>: VetoLib</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
	<?php echo $this->Html->meta('VetoLib','favicon.png',array('type' => 'icon','rel'=>'shortcut icon')); ?>
	<script type="text/javascript"> var baseUrl = '<?php echo Configure::read('App.siteUrl') ?>';  </script>
	<?php echo $this->Html->script('frontend/assets/js/jquery.js'); ?>
	<!-- CSS -->
	<?php echo $this->Html->css(array('frontend/assets/others/superlist.css','frontend/assets/others/custom.css')); ?>
	<!-- CSS -->
</head>
<body>
<script>
	var GOOGLE_APP_BROWSER_KEY = '<?php echo Configure::read('App.google_app_browser_key'); ?>';
	var GOOGLE_OAUTH_CLIENT_ID = '<?php echo Configure::read('App.google_oauth_client_id'); ?>';
</script>
<noscript><div class="row"><div class="col-sm-12 col-lg-12"><div class="alert alert-danger display-show">Kindly enable JavaScript to use the site properly.</div></div></div></noscript>
<div class="page-wrapper">
	<?php echo $this->element('client_header'); ?>
	<!-- BEGIN CONTAINER -->
	<?php echo $this->fetch('content'); ?>
	<!-- END CONTAINER -->
	<?php echo $this->element('client_footer'); ?>
</div>
<!-- Fonts -->
<?php echo $this->Html->css('https://fonts.googleapis.com/css?family=Nunito:300,400,700'); ?>
<?php echo $this->Html->css('https://fonts.googleapis.com/css?family=Montserrat:400,700'); ?>
<?php echo $this->Html->css('https://fonts.googleapis.com/css?family=Quicksand:400,700'); ?>
<?php echo $this->Html->css(array('frontend/assets/libraries/datepicker/new/bootstrap-datepicker3.css','frontend/assets/libraries/font-awesome/css/font-awesome.min.css','frontend/assets/libraries/bootstrap-select/bootstrap-select.min.css')); ?>
<!-- Fonts -->
<!-- Scripts -->
<?php echo $this->Html->script(array('frontend/assets/libraries/bootstrap-select/bootstrap-select.min.js','frontend/assets/others/custom.js','frontend/jquery.validate.js','frontend/assets/libraries/datepicker/new/bootstrap-datepicker.js','frontend/assets/libraries/datepicker/new/bootstrap-datepicker.fr.min.js','frontend/assets/libraries/bootstrap-sass/javascripts/bootstrap/dropdown.js','frontend/assets/others/chosen.jquery.js'));  
if($this->params['controller'] == 'pets'){ echo $this->Html->script('frontend/assets/others/managepets.js'); 
echo $this->Html->script(array('frontend/assets/libraries/amcharts/amcharts.js','frontend/assets/libraries/amcharts/serial.js'));
} ?>
<?php if(($this->params['controller'] == 'vets') && ($this->params['action']=='mySettings')){
echo $this->Html->script(array('frontend/jquery.validate.js','frontend/setting-form-validation.min.js')); } ?>
<?php if(($this->params['controller'] == 'vets') && ($this->params['action']=='changeplan')){
echo $this->Html->script(array('frontend/jquery.validate.js','frontend/changeplan-form-validation.min.js')); } ?>
<!-- Scripts -->
</body>
</html>