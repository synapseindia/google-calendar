<div class="main-inner pad-top pad-bottom">   
	<div id="search-list-page">
 
	<div class="container mid-cont">
	<?php 
		$m = utf8_encode('TAKE ONLINE APPOINTMENT');
		echo $this->Html->tag('h2', $m,array('class' => 'font-quicksand take-aapo')); 
	?>
    <div class="row">
		
		<div class="list-box clearfix" rel="vet">
			<div class="col-sm-6">
				<div class="need-hepl-map-box">
					<div class="contact-map">
						<div class="in-map clearfix">
							<?php echo $this->Html->tag('h2', $this->Html->tag('span', 1) .  $this->Html->link(htmlspecialchars('Dr. Syna', ENT_QUOTES, 'UTF-8'),'/vets/vetprofile/'.base64_encode(1),array('escape'=>false,'class'=>'')),array('class' => 'hd-up')); ?>
							<div class="col-sm-8 mob8-wd">
								
							</div>
						<?php echo $this->Html->div('clearfix',''); ?>
						</div>
					</div>
				</div><!-- /.need-hepl-map-box -->
			</div>
			<!-- calendar container Start ::-->
			<div class="col-sm-6">
				<?php $vet_id = 1;
					// Start date
					$date = date("Y-m-d");
					// End date
					$end_date = date('Y-m-d', strtotime("+1 week", strtotime($date)));
					// last week date
					$last_wk_date = date('Y-m-d', strtotime('next saturday', strtotime($end_date)));
						
					while (strtotime($date) <= strtotime($last_wk_date)) {
			            $dt[$date]='';
						$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
					}

					$caldata = $this->Calendar->getCalendar($result['Search']['id']);
					
					if(count($caldata)>0){
						$end_array = end($caldata);
						foreach($end_array as $end){
							$last_date = $end['available_date'];
						}
					}
					$slotkey = array();
					$exp =array();

					foreach($caldata as $data){
						$slotdata = explode(",", $data[0]['Slots']);
						$slotkey[$data['AvailabilitySetting']['available_date']] = $slotdata;
					}

					$slotArr=array();
					foreach($slotkey as $dtkey=>$dtArr){
						if(strtotime(date("Y-m-d")) <= strtotime($dtkey)){
							$slotArr[$dtkey]= $dtArr;
						}
					}

					$result = array_merge($dt, $slotArr);
					$totArr = array_chunk($result, 7,true); ?>
				<div class="agenda-container agenda-calender">
					<div class="agenda pr" align="center">
						<div class="left-cal-btn disabled pa" id="prevdiv_<?php echo $vet_id; ?>"><input type="button" value="" id="<?php  echo $vet_id; ?>_prev" class="prev" /></div>
                        <div class="right-cal-btn pa" id="nextdiv_<?php echo $vet_id; ?>"><input type="button" value="" id="<?php echo $vet_id; ?>_next" class="next" /></div>
                        <div id="container_<?php  echo $vet_id; ?>">
                        <h2><?php echo utf8_encode(strftime('%B %g',strtotime(date('Y-m-d')))); ?></h2>
						<div class="scroll-bottom prl-tbl">
                            <table>
                                <thead>
                                <?php 
									 date_default_timezone_set('Europe/Paris');
									foreach($totArr[0] as $key=>$val){ ?>
									<th class="disabled <?php /*<?php if(strtotime($key) == strtotime(date("Y-m-d"))){ ?>active <?php } ?>*/?>"><span ><?php echo ucfirst(strftime('%a',strtotime($key))); ?></span><br><?php echo date('d',strtotime($key)); ?></th>
								<?php } ?>
                                </thead>
                            	<tbody>
                            	<tr>
								<?php foreach($totArr[0] as $key=>$val){ ?>
									<td class="disabled active">
									<div class="slots pr">
									<div class="slide-up-des">
                                    <div class="slot_container">
									<?php 
									if(is_array($val)){ $cn=0;
										foreach($val as $slot){ $cn++; 
											if( strtotime($key.$slot)>=strtotime(date('Y-m-d H:i'))){
										
									?>
										<div class="slot <?php /*<?php if(strtotime($key) == strtotime(date("Y-m-d"))){ ?>act <?php } ?>*/?>"><?php echo $slot; ?></div>
									<?php 
											}
										
										} 
									}  
									
									?>
									</div>
                                    </div>
                                    <?php  if((count($val)>1)){ ?>
                                    <div class="top-cal-btn pa"><input type="button" value=""/></div>
                                    <div class="bottom-cal-btn pa"><input type="button" value=""/></div>
                                    <?php } ?>
									</div>
									</td>
								<?php } ?>
								<input type="hidden" id="<?php  echo $vet_id; ?>_nextdatecnt" value="1" />
								<input type="hidden" id="<?php  echo $vet_id; ?>_prevdatecnt" value="1" />
								<input type="hidden" id="<?php  echo $vet_id; ?>_last_date" value="<?php echo $last_date; ?>" />
								<input type="hidden" id="<?php  echo $vet_id; ?>_flag" value="0" />
								<input type="hidden" id="<?php  echo $vet_id; ?>_prevflag" value="0" />
							</tr>
                            </tbody>
                        </table>
                        </div>
						</div>
						<div class="no-availability loading">
							<div>
								<div class="info solo"> 
									<img src="<?php echo Configure::read('App.siteUrl'); ?>img/preloader.gif"> 
								</div>
							</div>
						</div>
					</div>
					</div>
			</div>			
        </div>
		<div class="list-pagins">
        </div><!-- /.list-pagins -->
	</div>	
	<input type="hidden" id="nextdate" value="" />
	<input type="hidden" id="prevdate" value="" />
 </div>
 </div><!-- /.search-list-page -->
</div><!-- /.main-inner -->
<script type="text/javascript">
$(document).ready(function(e) {
	countSlot=0;
	var setTop = 0;
	$('.bottom-cal-btn').on('click',function(){
		slotLen = $(this).parents('td.disabled').find('.slot').length;
		if((countSlot+4)>=slotLen){
			return false;
		}
		else{
			setTop += $('.slot').eq(countSlot).outerHeight(true);
			$(this).parents('td.disabled').find('.slot_container').animate({'top':-setTop});
			countSlot++;
		}
	});
	$('.top-cal-btn').on('click',function(){
		if((countSlot-1)<0){
			return false;	
		}
		else{
			setTop -= $('.slot').eq(countSlot).outerHeight(true);
			$(this).parents('td.disabled').find('.slot_container').animate({'top':-setTop});
			countSlot--;
		}
	})
	$(document).on('click', '.prev', function(){ 
		var ID = $(this).attr('id').split('_')[0];
		$("#"+ID+"_prev").unbind('click');
		$("#"+ID+"_nextdatecnt").val(parseInt($("#"+ID+"_nextdatecnt").val())-1);
		$("#nextdiv_"+ID).removeClass('disabled');
		$("#"+ID+"_next").attr('disabled',false);
		if($("#"+ID+"_prevflag").val()==1){
			$("#"+ID+"_prev").attr('disabled',true);
			$("#prevdiv_"+ID).addClass('disabled');
			$("#"+ID+"_nextdatecnt").val(1);
			return false;
		}
		var today_date = new Date($("#nextdate").val());
		today_date.setDate(today_date.getDate() - 7);
		var new_date = new Date(today_date);
		var day = new_date.getDate();
		var monthIndex = parseInt(new_date.getMonth())+1;
		var year = new_date.getFullYear();
		if(day<10){day = '0'+day}
		if(monthIndex<10){monthIndex = '0'+monthIndex}
		var date_format = year+'-'+monthIndex+'-'+day;
		$("#nextdate").val(date_format);
		var Url = baseUrl+'/index/prev_ajax_cal';
		$.ajax({
			url: Url,
			type: "POST",
			data:  {
				vet_id:ID,
				nextdate : $("#nextdate").val(),
				last_date : $("#"+ID+"_last_date").val(),
				nextdatecnt : $("#"+ID+"_nextdatecnt").val()
			},
			beforeSend: function(){
				$("#"+ID+"_prev").attr('disabled',true);
                $("#prevdiv_"+ID).addClass('disabled');
                $("#nextdiv_"+ID).addClass('disabled');
                $("#"+ID+"_next").attr('disabled',true);
                $(".no-availability.loading").show();
			},
			complete: function(){
				$(".no-availability.loading").hide();
                $("#"+ID+"_prev").attr('disabled',false);
                $("#prevdiv_"+ID).removeClass('disabled');
                $("#nextdiv_"+ID).removeClass('disabled');
                $("#"+ID+"_next").attr('disabled',false);
                $("#"+ID+"_prev").bind('click');
			},
			success: function(data){
				$("#container_"+ID).html(data);
			},
			error: function(){} 	        
	   });
	});
	
	$(document).on('click', '.next', function(){ 
		var ID = $(this).attr('id').split('_')[0];
		$("#"+ID+"_next").unbind('click');
		$("#"+ID+"_nextdatecnt").val(parseInt($("#"+ID+"_nextdatecnt").val())+1);
		if($("#"+ID+"_flag").val()==1){
			$("#"+ID+"_next").attr('disabled',true);
			$("#nextdiv_"+ID).addClass('disabled');
			return false;
		}
		if($("#"+ID+"_nextdatecnt").val()<=2){
			var today_date = new Date();
			$("#prevdiv_"+ID).removeClass('disabled');
			$("#"+ID+"_prev").attr('disabled',false);
		}else{
			var today_date = new Date($("#nextdate").val());
			$("#prevdiv_"+ID).removeClass('disabled');
			$("#"+ID+"_prev").attr('disabled',false);
		}
		today_date.setDate(today_date.getDate() + 7);
		var new_date = new Date(today_date);
		var day = new_date.getDate();
		var monthIndex = parseInt(new_date.getMonth())+1;
		var year = new_date.getFullYear();
		if(day<10){day = '0'+day}
		if(monthIndex<10){monthIndex = '0'+monthIndex}
		var date_format = year+'-'+monthIndex+'-'+day;
		$("#nextdate").val(date_format);
		var Url = baseUrl+'/index/ajax_cal';
		$.ajax({
			url: Url,
			type: "POST",
			data:  {
				vet_id:ID,
				nextdate : $("#nextdate").val(),
				last_date : $("#"+ID+"_last_date").val(),
				nextdatecnt : $("#"+ID+"_nextdatecnt").val()
			},
			beforeSend: function(){
				$("#"+ID+"_prev").attr('disabled',true);
                $("#prevdiv_"+ID).addClass('disabled');
                $("#nextdiv_"+ID).addClass('disabled');
                $("#"+ID+"_next").attr('disabled',true);
                $(".no-availability.loading").show();
			},
			complete: function(){
				$(".no-availability.loading").hide();
                $("#"+ID+"_prev").attr('disabled',false);
                $("#prevdiv_"+ID).removeClass('disabled');
                $("#nextdiv_"+ID).removeClass('disabled');
                $("#"+ID+"_next").attr('disabled',false);
                $("#"+ID+"_next").bind('click');
			},
			success: function(data){
				$("#container_"+ID).html(data);
			},
			error: function(){} 	        
	   });
	});
});
</script>
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.11.4/themes/ui-lightness/jquery-ui.css" />
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
function getUserLocation() { if (navigator.geolocation) { navigator.geolocation.getCurrentPosition(setUserPosition); } else { alert("Geolocation is not supported by this browser."); } } function setUserPosition(position) { var latlng = {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)}; var geocoder = new google.maps.Geocoder; geocoder.geocode({'location': latlng}, function(results, status) { if (status === google.maps.GeocoderStatus.OK) { if (results[0]) { document.getElementById('geocomplete').value = results[0].address_components[0].long_name; } else { alert('NO results found. Please provide address.'); } } else { alert('Geocoder failed due to: ' + status + '. Please provide address.'); } }); $('#curlat').val(position.coords.latitude); $('#curlng').val(position.coords.longitude); }  
//$(function() { $(document).on('click','.loc-home-icon',function(){ getUserLocation(); });	
$(function() { $(document).on('click','.loc-home-icon',function(){ geolocate(); });
$("#SearchName").autocomplete({ source: function(request, response) { $.ajax({ url: baseUrl + 'vets/getVetlistBygeo', dataType: "json", data: { term : request.term, curlat : $("#curlat").val(), curlng : $("#curlng").val() }, success: function(data) { if(!Object.keys(data).length){ var noresult = {value:"",label:"No results found. Please try some other name."}; data.push(noresult); } response(data); } }); }, min_length: 1, delay: 300 }); $("#geocomplete").geocomplete({ details: "form", detailsAttribute: "data-geo" }); });

function geolocate() {
	$('.loc-home-icon').addClass('loc-preloader-icon');
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			$.ajax({
				url:'https://maps.googleapis.com/maps/api/geocode/json?latlng='+position.coords.latitude+','+position.coords.longitude,
				success:function(data){
					if (data.status == 'OK') {
						var place = data.results[0];
						//alert(place);
						var arrondissement = ''; var adresse_number = ''; var adresse = ''; var ville = ''; var departement = ''; var region = ''; var pays = ''; var code_postal = ''; var latitude = ''; var longitude = '';
						var place = data.results[0];
						for (i=0;i<place.address_components.length;i++) {
							if (place.address_components[i].types[0] == 'street_number') adresse_number = place.address_components[i].long_name;
							else if (place.address_components[i].types[0] == 'route') adresse = place.address_components[i].long_name;
							else if (place.address_components[i].types[0] == 'sublocality') arrondissement = place.address_components[i].long_name;
							else if (place.address_components[i].types[0] == 'locality') ville = place.address_components[i].long_name;
							else if (place.address_components[i].types[0] == 'administrative_area_level_2') departement = place.address_components[i].long_name;
							else if (place.address_components[i].types[0] == 'administrative_area_level_1') region = place.address_components[i].long_name;
							else if (place.address_components[i].types[0] == 'country') pays = place.address_components[i].long_name;
							else if (place.address_components[i].types[0] == 'postal_code') code_postal = place.address_components[i].long_name;
						}
						if (arrondissement != '') ville += ' '+arrondissement;
						if (adresse_number != '') adresse = adresse_number+' '+adresse;
						//var latitude = place.geometry.location.G;
						//var longitude = place.geometry.location.K;
						var latitude = place.geometry.location.lat;
						var longitude = place.geometry.location.lng;
						
						var final_adress = '';
						if (adresse != '') final_adress += adresse;
						if (adresse_number != '') {
							if (final_adress != '') final_adress += ', ';
							final_adress += ville;
						}
						if (adresse_number != '') {
							if (final_adress != '') final_adress += ', ';
							final_adress += pays;
						}
						$('.loc-home-icon').removeClass('loc-preloader-icon');
						$('#geocomplete').val(final_adress); 
						$('#curlat').val(latitude); 
						$('#curlng').val(longitude);
					}
				}
			});
		});
	}
}

function check(){
	//alert('I am here....');
	//return false;
	var error = 0;
	if($('#SearchName').val() == '' && $('#geocomplete').val() == ''){
		$('#SearchName').parent().addClass('error');
		$('#geocomplete').parent().addClass('error');
		error = 1;
	}else{
		$('#SearchName').parent().removeClass('error');
		$('#geocomplete').parent().removeClass('error');
	}
	
	if(error == 1){
		return false;
	}else{
		return true;
	}
}


$(document).ready(function(){
	
$('#SearchName').on('blur', function(){$('#SearchName').parent().removeClass('error');$('#geocomplete').parent().removeClass('error');}).on('focus', function(){$('#SearchName').parent().removeClass('error');$('#geocomplete').parent().removeClass('error');});
	
$('#geocomplete').on('blur', function(){$('#SearchName').parent().removeClass('error');$('#geocomplete').parent().removeClass('error');
}).on('focus', function(){$('#SearchName').parent().removeClass('error');$('#geocomplete').parent().removeClass('error');});	
	
});

$('#SearchName').keypress(function(e) {if (e.keyCode == 13) {$('.search-h').click();}});

$('#geocomplete').keypress(function(e) {
	if (e.keyCode == 13) { 
		if($('#curlat').val() == '' || $('#curlng').val() == ''){ return false;}else{$('.search-h').click();}
	}
});


</script>
 <style type="text/css">
.error {border:1px solid #ff0000;}
 </style>