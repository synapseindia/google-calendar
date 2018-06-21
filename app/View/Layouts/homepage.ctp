<?php echo $this->Html->docType('html5'); ?>
<html dir="ltr" lang="fr">
<head>
	<?php echo $this->Html->charset(); ?>
	<!--<title><?php //echo (!empty($site_title))?$site_title:'Page :'; ?>: VetoLib</title>-->
	<title><?php echo utf8_encode('Clubvet Rendez-vous : Prenez rendez-vous en ligne chez un vétérinaire'); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
	<meta name="google-site-verification" content="q12EDeKvKrRE45VMFpw8pcsi1o2lhp0EVM4NTBC05nY" />
	<meta name="description" content="<?php echo utf8_encode('Trouvez rapidement un vétérinaire près de chez vous et prenez rendez-vous gratuitement en ligne en quelques clics.'); ?>">
	<?php if(($this->params['controller'] == 'vets') && ($this->params['action']=='vetprofile') ){?>
		<meta name="description" content="<?php echo $metaprofile ; ?>">
	<?php } ?>
	<?php if(($this->params['controller'] == 'index') && ($this->params['action']=='search') ){?>
		<meta name="description" content="<?php echo $searchmeta ; ?>">
	<?php } ?>

	<?php echo $this->Html->meta('Clubvet Rendez-vous','favicon.png',array('type' => 'icon','rel'=>'shortcut icon')); ?>
	<base href="<?php echo Configure::read('App.siteUrl') ?>" />
	<script type="text/javascript"> var baseUrl = '<?php echo Configure::read('App.siteUrl') ?>';  </script>
	<!-- Re-CSS-JS -->	
	<?php echo $this->Html->css(array('frontend/assets/others/custom.css','frontend/assets/others/superlist.css')); ?>
	<?php echo $this->Html->script('frontend/assets/js/jquery.js'); ?>
	<!-- Re-CSS-JS -->
</head>
<body>
<noscript><div class="row"><div class="col-sm-12 col-lg-12"><div class="alert alert-danger display-show" style="text-align:center;">Kindly enable JavaScript to use the site properly.</div></div></div></noscript>
<div class="page-wrapper">
	<?php //echo $this->element('frontend_header'); ?>
	<!-- BEGIN CONTAINER -->
	<div class="main">
	<?php echo $this->fetch('content'); ?>
	</div>
	<!-- END CONTAINER -->
	<?php //echo $this->element('frontend_footer'); ?>
</div>
<?php if( !$this->Session->check('client') ){ ?>
<?php echo $this->element('login_popup'); ?>
<?php } ?>
<!-- Fonts -->
<?php echo $this->Html->css('https://fonts.googleapis.com/css?family=Nunito:300,400,700');echo $this->Html->css('https://fonts.googleapis.com/css?family=Montserrat:400,700'); 
echo $this->Html->css('https://fonts.googleapis.com/css?family=Quicksand:400,700'); ?>
<!-- Fonts -->
<!-- CSS -->
<?php echo $this->Html->css(array('frontend/assets/libraries/font-awesome/css/font-awesome.min.css','frontend/assets/libraries/bootstrap-select/bootstrap-select.min.css')); 
if($this->params['controller'] != 'index' && $this->params['action'] != 'index'){
	echo $this->Html->css(array('frontend/assets/libraries/colorbox/colorbox.css','frontend/assets/libraries/owl-carousel/owl.carousel.css','frontend/assets/libraries/bootstrap-fileinput/fileinput.min.css','custom.css'));
}
?>
<!-- CSS -->
<!-- Scripts -->
<?php echo $this->Html->script(array('frontend/geocode/jquery.geocomplete.js','frontend/assets/libraries/bootstrap-sass/javascripts/bootstrap/collapse.js','frontend/assets/libraries/bootstrap-sass/javascripts/bootstrap/dropdown.js','frontend/assets/libraries/bootstrap-select/bootstrap-select.min.js','frontend/assets/others/custom.js'));
if( $this->params['controller'] == 'index' && $this->params['action'] == 'index' ) { 
	echo $this->Html->script('
https://maps.googleapis.com/maps/api/js??sensor=false&amp;libraries=places&amp;key=AIzaSyCojsCsC2kYHKphj30UTESHopEYjOD_Zwk');
//echo $this->Html->script(array('jquery-notify.min.js','jquery-easy-eu-cookie-law.min.js')); 
} else {
	echo $this->Html->script(array('
https://maps.googleapis.com/maps/api/js??sensor=false&amp;libraries=weather,geometry,visualization,places,drawing&amp;key=AIzaSyCojsCsC2kYHKphj30UTESHopEYjOD_Zwk','frontend/assets/libraries/jquery-google-map/infobox.js','frontend/assets/libraries/jquery-google-map/jquery-google-map.js')); 
} 
/* Form Validation Script */
if( ($this->params['controller'] == 'vets') && ($this->params['action']=='register') ){
	echo $this->Html->script(array('frontend/jquery.validate.js','frontend/vet-form-validation.min.js')); 
} 
if( ($this->params['controller'] == 'vets') && ($this->params['action']=='subscribe') ){
	echo $this->Html->script(array('frontend/jquery.validate.js','frontend/bank-form-validation.min.js')); 
} 
if( ($this->params['controller'] == 'vets') && ($this->params['action']=='vetprofile') ){
	echo $this->Html->script(array('frontend/jquery.validate.js','frontend/email-form-validation.min.js')); 
} 
/* Form Validation Script */
?>
<script type="text/javascript"> $('select').selectpicker();</script>
<!-- Scripts -->
</body>
</html>