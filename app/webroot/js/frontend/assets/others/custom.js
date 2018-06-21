// JavaScript Document
$("#header-dd").hide();
$(document).on('click','.sidebar-secondary-admin.header-dash-no-hov ul li a',function(){
	$(this).next("#header-dd").slideToggle("fast");	
	$(this).parent(".sidebar-secondary-admin.header-dash-no-hov ul li").siblings().find("#header-dd").slideUp("fast");
});

// login Pop Up
$('.login--popup').click(function() {
    $('.login--popup-cont').fadeIn();
	$('.login-reg-form').addClass('fadein'); 
	$('body').addClass('popup-open');
});

$('.signin--popup').click(function() {
	$('.forgot-reg-form').removeClass('fadein').fadeOut(function(){$('.login-reg-form').fadeIn();$('.login-reg-form').addClass('fadein');});
});

$('.forgot--popup').click(function() {
	$('.login-reg-form').removeClass('fadein').fadeOut(function(){$('.forgot-reg-form').fadeIn();$('.forgot-reg-form').addClass('fadein');});
});

$('.close-all, .close--popup').click(function() {
    $('.login--popup-cont').fadeOut(function(){
		$('body').removeClass('popup-open'); 
		$('.login-reg-form').css('display','');
		$('.forgot-reg-form').css('display','none');
	});
	$('.login-reg-form, .forgot-reg-form').removeClass('fadein');
});
// login Pop Up



$('.setting-dd').on('click', function(){
  $('.setting-dd-box').slideToggle();
});


// Sidebar Pet Medical Details

$(".pet-details-view").show();
$('.pet-details-heading h4').click(function(){
  
  $(this).parent().siblings('.pet-details-heading').removeClass('selected');
  $(this).siblings('div').slideToggle(250);
  $(this).parent().addClass('selected');
})


// Pet Detail Form Pop Up

$('.setting-dd-box a.pet-detail').on('click', function(){
  $('.pet-full-detail-form').fadeIn();
});

// Pet Weight Detail Pop Up

$('.setting-dd-box a.weight-detail').on('click', function(){
  getweightlist();
  $('.weight-form-container').fadeIn();
});

// Pet Height Detail Pop Up 

$('.setting-dd-box a.height-detail').on('click', function(){
  getheightlist();
  $('.height-form-container').fadeIn();
});

// Pet Rib cage Circumference Detail pop Up
$('.setting-dd-box a.rib-cage-detail').on('click', function(){
	getribcagelist();
	$('.rib-cage-form-container').fadeIn();
});

// Pet Ankle Length Detail Pop Up
$('.setting-dd-box a.ankle-detail').on('click', function(){
	getanklelist();
	$('.ankle-form-container').fadeIn();
});

// Pet Medicine Detail Pop Up 

$('.setting-dd-box a.medicine-detail').on('click', function(){
	getmedicinelist();
	$('.medicine-form-container').fadeIn();
});

// Pet Vaccine Detail Pop Up 

$('.setting-dd-box a.vaccine-detail').on('click', function(){
	getvaccinelist();
	$('.vaccine-form-container').fadeIn();
});

// Pet Comment Detail Pop Up 

$('.setting-dd-box a.comment-detail').on('click', function(){
	getcommentlist();
	$('.comment-form-container').fadeIn();
});

// Remove Pet Details 

$('.setting-dd-box a.remove-detail').on('click', function(){
	$('.delete-form-container').fadeIn();	
});


// NEW Pop Up Close Button

$('.close').on('click', function(){
  if ($(this).parent('form').length){
	$(this).parent('form').get(0).reset();
	$(this).parent('form').find('select').selectpicker('render').selectpicker('refresh');
	$(this).parent('form').find('select').selectpicker('refresh');
  }
  $('.pet-form-container').fadeOut();
});

// OLD Pop Up Close Button
$('.form-close-btn').on('click', function(){
  if ($(this).parent('form').length){
	$(this).parent('form').get(0).reset();
	$(this).parent('form').find('select').selectpicker('render').selectpicker('refresh');
	$(this).parent('form').find('select').selectpicker('refresh');
  }
  $('.pet-form-container').fadeOut();
});

// to close popup if escapse key is pressed.
if ($('.pet-form-container').length){
	$(document).on('keydown', function (e) {
		if(e.keyCode == 27){
			$('.pet-form-container').fadeOut();
		}
	});
}



$(document).ready(function() {
	$(window).scroll(function() {
		var headTop = $('.scroll-map').height();
		if ( $(this).scrollTop() >= headTop ) {
			
			$('.fixed-form').addClass("fixed-top");
			$('h3.top-form-title').css('display','none');
		} else {
			
			$('.fixed-form').removeClass("fixed-top");
			$('h3.top-form-title').css('display','block');
		}
	});
});

// profile page toggle
if($('select').length){ $('select').selectpicker(); }
$('.pro-comt-dash-view').slideUp();
$('.pro-comt-dash h4').on('click',function(){
	$(this).toggleClass('selected');
	$('.pro-comt-dash-view').slideToggle();
});

var formOpen1="closed";
var formOpen2="closed";
var formOpen3="closed";


$('.personal-form-dash h4').on('click',function(){
	if($(this).hasClass('selected')){
		formOpen1="closed";
	}else{
		formOpen1="open";
	}
	$(this).toggleClass('selected');
	$('.personal-form-dash-view').slideToggle();
	localStorage.formOpen1 = formOpen1;
});

$('.personal-form-dash-2 h4').on('click',function(){
	if($(this).hasClass('selected')){
		formOpen2="closed";
	}else{
		formOpen2="open";
	}
	$(this).toggleClass('selected');
	$('.personal-form-dash-view-2').slideToggle();
	localStorage.formOpen2 = formOpen2;
});

$('.personal-form-dash-3 h4').on('click',function(){
	if($(this).hasClass('selected')){
		formOpen3="closed";
	}else{
		formOpen3="open";
	}
	$(this).toggleClass('selected');
	$('.personal-form-dash-view-3').slideToggle();
	localStorage.formOpen3 = formOpen3;
});

if(localStorage.formOpen1=="open"){
	$('.personal-form-dash h4').addClass('selected');
	$('.personal-form-dash-view').show();
}

if(localStorage.formOpen2=="open"){
	$('.personal-form-dash-2 h4').addClass('selected');
	$('.personal-form-dash-view-2').show();
}
if(localStorage.formOpen3=="open"){
	$('.personal-form-dash-3 h4').addClass('selected');
	$('.personal-form-dash-view-3').show();
}

$('#personal-form-range-3 .form-close-btn').click(function(){
  $(this).closest('.personal-form-dash-view-3').slideUp();
  $(this).closest('.personal-form-dash-view-3').siblings().removeClass('selected');
  localStorage.formOpen2="closed";
});

$('#personal-form-range-2 .form-close-btn').click(function(){
  $(this).closest('.personal-form-dash-view-2').slideUp();
  $(this).closest('.personal-form-dash-view-2').siblings().removeClass('selected');
  localStorage.formOpen2="closed";
});

$('#personal-form-range .form-close-btn').click(function(){
  $(this).closest('.personal-form-dash-view').slideUp();
  $(this).closest('.personal-form-dash-view').siblings().removeClass('selected');
  localStorage.formOpen1="closed";
});

/*--------- Edited On 20-04-2016 Slider Issues By Siddhant -----------------*/

$('a.add_pets_pop').on('click', function(){
  $('.pet-full-detail-form').fadeIn();
});