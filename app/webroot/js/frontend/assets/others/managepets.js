$('.setting-dd-box a.edit-detail').on('click', function(){
  $('.pet-edit-detail-form').fadeIn();
});
function readURL(input) {
	var selected_pet = $('#selected_pet').val();
	if (input.files && input.files[0] && selected_pet) {		
		var file = new FormData();
		file.append('file', $('input[type=file]')[0].files[0]);
		$.ajax({
			url: baseUrl+'pets/update_image?pet_id='+selected_pet,
			type: 'POST',
			dataType: 'json',
			beforeSend: function(){
				$('.success').remove();
				$('.error').remove();
			},
			success: function(result){
				if(result.success){
					$('.pet-image-container').after('<p class="success">'+result.success+'</p>');
				} else {
					$('.pet-image-container').after('<p class="error">'+result.error+'</p>');
				}
			},
			data: file,
			cache: false,
			contentType: false,
			processData: false,
		});
		var reader = new FileReader();		
		reader.onload = function (e) {
			$('#cImg')
				.attr('src', e.target.result);
		};		
		reader.readAsDataURL(input.files[0]);
	} else {
		$('.pet-image-container').after('<p class="error">Please select your Pet.</p>');
	}
}